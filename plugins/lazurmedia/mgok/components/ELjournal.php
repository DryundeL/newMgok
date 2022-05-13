<?php

namespace LazurMedia\Mgok\Components;

use Illuminate\Console\Scheduling\Schedule;
use Lazurmedia\Mgok\Components\Authorization;
use Lazurmedia\Mgok\Models\Journal as JournalModel;
use Lazurmedia\Mgok\Models\FinalGrades;
use Lazurmedia\Mgok\Models\AddictionalLessons;
use Lazurmedia\Mgok\Models\Schedule as ScheduleModel;
use Lazurmedia\Mgok\Classes\Dates as DatesClass;
use Lazurmedia\Mgok\Classes\Schedule as ScheduleClass;
use Lazurmedia\Mgok\Classes\Journal as JournalClass;
use Lazurmedia\Mgok\Models\Users;
use Request;
use Redirect;

class ELjournal extends \Cms\Classes\ComponentBase
{
  public $groups = [];
  public $days = [];
  public $addictives;
  public $marks;
  public $result_marks;

  public $subjects;
  public $lessons;

  public $teacher;

  public $role;

  public $students;

  public $months = ['Январь', 'Февраль', 'Март','Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
  public $month;

  public function componentDetails()
  {
    return [
      'name' => 'Электронный журнал',
      'description' => 'Электронный журнал'
    ];
  }

  public function onRun() 
  {
    
    $this->role = Authorization::getRole();
    
    if ($this->role !== 'Преподаватель' && $this->role !== 'Студент' && $this->role !== 'Модератор') {
      return Redirect::to('/');
    }
    
    return $this->main();
  }

  private function main()
  {
    if ($this->role === 'Преподаватель')
    {
      $this->getGroupsForTeacher(); 
      $this->getSubjectsForTeacher();
      $this->getStudentsForTeacher();
      $this->getDates();
      $this->getMarks();
      $this->getAddictiveMarks();
      $this->getTeacherForSubject();
    } 
    else if ($this->role === 'Студент') 
    {
      $this->getSubjectsForStudent();
      $this->getClassmates();
      $this->getDates();
      $this->getMarks();
      $this->getAddictiveMarks();
      $this->getTeacherForSubject();
    }
    else {
      $this->getGroupsforModer();
      $this->getSubjectsforModer();
      $this->getStudentsForModer();
      $this->getDates();
      $this->getMarks();
      $this->getAddictiveMarks();
      $this->getTeacherForSubject();
    }
  }

  private function getTeacherForSubject(){
    $group = Request::get('group') ?? $this->groups[0];
    $subject = Request::get('subject') ?? $this->subjects[0]->lesson_name;
    $this->teacher = ScheduleModel::where('class', $group)->where('lesson_name', $subject)->first();
  }

  private function getGroupsforModer()
  {
    $user = Authorization::getUser();
    $this->groups = explode(',', $user->class);
  }

  private function getSubjectsForModer()
  {
    $group = Request::get('group') ?? $this->groups[0];
    $this->subjects = JournalClass::getSubjectsForModer($group);
  }

  private function getStudentsForModer()
  {
    $group = Request::get('group') ?? $this->groups[0];
    $this->students = JournalClass::getStudentsByGroup($group);
  }

  private function getGroupsForTeacher() 
  {
    $teacher_full_name = Authorization::getName();
    $groups = JournalClass::getGroupsByTeacher($teacher_full_name)->map->class;
    
    foreach($groups as $group) {
      $first_letter = explode('-', $group)[0];
      if (!is_numeric($first_letter)) {
        array_push($this->groups, $group);
      }
    }
  }

  private function getSubjectsForTeacher() 
  {
    $group = Request::get('group') ?? $this->groups[0];
    $teacher_name = Authorization::getName();
    $this->subjects = JournalClass::getSubjectsForTeacher($teacher_name, $group);
  }

  private function getStudentsForTeacher() {
    $group = Request::get('group') ?? $this->groups[0];
    $this->students = JournalClass::getStudentsByGroup($group);
  }
  
  private function getSubjectsForStudent() 
  {
    $this->groups[0] = Authorization::getClass();
    $this->subjects = JournalClass::getSubjectsForStudent($this->groups[0]);
  }

  private function getClassmates() {
    $group = Authorization::getClass();
    $this->students = JournalClass::getStudentsByGroup($group);
  }

  private function getDates() {
    $group = Request::get('group') ?? $this->groups[0];
    $year = $this->getYear();
    $month_index = $this->getMonth();
    $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month_index, $year);

    $this->days = [];
    for($i = 1; $i <= $number_of_days; $i++) {
      $date = "$year-$month_index-$i";
      $parity = (new DatesClass)->getParity($date);
      $day_of_week = (new DatesClass)->getDayOfWeek($date);
      $subject = Request::get('subject') ?? $this->subjects[0]->lesson_name;
      $lessons = (new ScheduleModel)->getLessonByDay($group, $day_of_week, $parity, $subject);
      if (count($lessons) > 0) {
        foreach($lessons as $lesson) {
          $day = [
            'date' => $i,
            'number_lesson' => $lesson->number_lesson
          ];
          array_push($this->days, $day);
        }
      }
    }
  }

  private function getYear() {
    $year = date("Y");
    $month = date('m');
    $semester = (int) Request::get('semester') ?? 1;
    if ($month < 8 && $semester === 1) {
      $year--;
    }
    return (string) $year;
  }

  private function getMonth() {
    $month = Request::get('month');
    if (!$month) {
      $month = date('n');
    } else {
      $months = ['Январь', 'Февраль', 'Март','Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
      $month = array_search($month, $months) + 1;
    }
    return $month;
  }

  private function getMarks() {
    $year = $this->getYear();
    $month_index = $this->getMonth();
    $group = Request::get('group') ?? $this->groups[0];
    $subject = Request::get('subject') ?? $this->subjects[0]->lesson_name;
    foreach($this->days as $day) {
      $date = "$year-$month_index-$day[date]";
      $colection_marks_of_class_by_day = JournalModel::getClassMarksByDay($group, $subject, $day['number_lesson'], $date);   

      $marks = [];
      foreach($colection_marks_of_class_by_day as $collection) {
        array_push($marks, $collection->mark);
      }

      $this->marks[] = $marks ?? [];
    }
    //var_dump($this->marks);
  }

  private function getAddictiveMarks() {
    $month_index = $this->getMonth();
    $group = Request::get('group') ?? $this->groups[0];
    $subject = Request::get('subject') ?? $this->subjects[0]->lesson_name;
    $addictive_marks = AddictionalLessons::where('class', $group)
      ->where('subject', $subject)
      ->get()
      ->unique('date_lesson');
    $addictives = [];
    foreach ($addictive_marks as $addictive)
    {
      $addictive_month = date_parse($addictive->date_lesson)['month'];
      if ($month_index == $addictive_month)
      {
        array_push($addictives, $addictive);
      }
    }
    $this->addictives = $addictives;
  }

  private function getMonthNumber($name) {
    $months = ['Январь' => '01', 'Февраль' => '02', 'Март' => '03','Апрель' => '04', 'Май' => '05', 'Июнь' => '06', 'Июль' => '07', 'Август' => '08', 'Сентябрь' => '09', 'Октябрь' => '10', 'Ноябрь' => '11', 'Декабрь' => '12'];
    return $months[$name];
  }

  // -- Events -- //

  public function onGetMarks() {
    $data = post();
    $group = $data['group'];
    $subject = $data['subject'];
    $month_name = $data['month'];

    $year = $this->getYear();
    $month = $this->getMonthNumber($month_name);
    $dates = "$year-$month-%";
    $students = (new JournalClass)->getStudentsByGroup($group);

    $response = [];
    foreach($students as $student) {
      $marks_for_month = JournalModel::where('date', 'like', $dates)
        ->where('class', $group)
        ->where('subject', $subject)
        ->where('student', $student->full_name)
        ->get()
        ->sortBy('student');

      $student_array = array(
        'full_name' => $student->full_name,
        'marks' => [] 
      );

      foreach($marks_for_month as $mark) {
        $mark_array = array(
          'date' => $mark->date,
          'mark' => $mark->mark,
          'number_lesson' => $mark->number_lesson,
        );
        array_push($student_array['marks'], $mark_array);
      }
      array_push($response, $student_array);
    }
    return $response;
  }

  public function onGetAdditionalMarks() {
    $data = post();
    $group = $data['group'];
    $subject = $data['subject'];
    $month_name = $data['month'];

    $year = $this->getYear();
    $month = $this->getMonthNumber($month_name);
    $dates = "$year-$month-%";
    $students = (new JournalClass)->getStudentsByGroup($group);
    
    $response = [];
    
    foreach($students as $student) {
      $marks_for_month = AddictionalLessons::where('date_lesson', 'like', $dates)
        ->where('class', $group)
        ->where('subject', $subject)
        ->where('student', $student->full_name)
        ->get()
        ->sortBy('student');

      $student_array = array(
        'full_name' => $student->full_name,
        'marks' => [] 
      );

      foreach($marks_for_month as $mark) {
        $mark_array = array(
          'date' => $mark->date_lesson,
          'mark' => $mark->mark,
          'unique_id' => $mark->unique_id,
        );
        array_push($student_array['marks'], $mark_array);
      }
      array_push($response, $student_array);
    }
    return $response;
  }

  public function onSaveMarks() 
  { 
    $data = post();
    $group = $data['group'];
    $subject = $data['subject'];
    $marks = [];
    if (isset($data['marks'])) {
      $marks = $data['marks'];
    }
    
    foreach($marks as $mark) {
      (new JournalModel)->createMark($group, $subject, $mark);
    }

    if (array_key_exists('addictive', $data)){
      $addictives = $data['addictive'];
      foreach($addictives as $addictive) {
        (new AddictionalLessons)->createAddictiveMark($group, $subject, $addictive);
      }
    }

    return back();
  }

  public function onDeleteAddict()
  {
    $data = post();
    $unique_id = $data['unique_id'];
    (new AddictionalLessons)->deleteMarks($unique_id);
  }  
}
?>