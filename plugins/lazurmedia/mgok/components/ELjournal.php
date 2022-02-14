<?php

namespace LazurMedia\Mgok\Components;

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
  public $groups;
  public $days = [];
  public $addictives;
  public $marks;
  public $result_marks;

  public $subjects;
  public $lessons;



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
    
    if ($this->role !== 'Преподаватель' && $this->role !== 'Студент') {
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
      $this->getFinalMarks();
    } else {
      $this->getSubjectsForStudent();
      $this->getClassmates();
      $this->getDates();
      $this->getMarks();
      $this->getAddictiveMarks();
      $this->getFinalMarks();
    }
  }

  private function getGroupsForTeacher() 
  {
    $teacher_full_name = Authorization::getName();
    $this->groups = JournalClass::getGroupsByTeacher($teacher_full_name)->map->class;
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

      foreach($colection_marks_of_class_by_day as $collection) {
        $marks[] = $collection->mark;
      }

      $this->marks[] = $marks ?? [];
    }
  }

  private function getAddictiveMarks() {
    $month_index = $this->getMonth();
    $group = Request::get('group') ?? $this->groups[0];
    $subject = Request::get('subject') ?? $this->subjects[0]->lesson_name;
    $addictive_marks = AddictionalLessons::where('class', $group)->where('subject', $subject)->get();
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

  private function getFinalMarks() {
    $year = $this->getYear();
    $month_index = $this->getMonth();
    $month = $this->months[$month_index - 1];
    $group = Request::get('group') ?? $this->groups[0];
    $subject = Request::get('subject') ?? $this->subjects[0]->lesson_name;

    $finals = (new FinalGrades)->getFinalMarks($group, $subject, $month);

    $this->result_marks = $finals ?? [];
  }

  // -- Events -- //

  public function onSaveMarks() 
  { 
    $data = post();
    $group = $data['group'];
    $subject = $data['subject'];
    $marks = $data['marks'];
    $addictives = $data['addictive'];
    $finals = $data['final'];
    
    foreach($marks as $mark) {
      (new JournalModel)->createMark($group, $subject, $mark);
    }

    foreach($addictives as $addictive) {
      (new AddictionalLessons)->createAddictiveMark($group, $subject, $addictive);
    }

    foreach($finals as $final) {
      (new FinalGrades)->createFinalMark($group, $subject, $final);
    }

    return back();
  }

  public function onDeleteAddict()
  {
    $data = post();
    $unique_id = $data['unique_id'];
    (new AddictionalLessons)->deleteMarks($unique_id);
  }


  // Старый код

  // private function getClassmates() 
  // {
  //   $class = Authorization::getClass();
  //   $classmates = Users::where('class', $class)->where('role', 'Ученик')->get()->sortBy('full_name');
  //   $this->classmates = $classmates;

  // }

  private function getStudentsByGroup()
  {
    $class = Request::get('group');
    $groups = $this->getGroupsForTeacher();
    $groups_arr = [];
    foreach ($groups as $group)
    {
      array_push($groups_arr, Users::where('role', 'Ученик')->where('class', $group->class)->get()->sortBy('full_name'));
    }
    if (count($groups_arr)!=0){
      if (!$class){
        $this->students = $groups_arr[0];
      }
      else {
        $this->students = Users::where('role', 'Ученик')->where('class', $class)->get()->sortBy('full_name');
      }
    }
    return $groups_arr;
  }

  private function getMonthsBySemester() 
  {
    $semester = Request::get('semester');
    $parity = $semester % 2;
    if (!$semester){
      $month_now = date('n');
      if ((int)$month_now < 8)
      {
        $this->semesters = [2, 1];
        $parity = 0;
      }
      else
      {
        $this->semesters = [1, 2];
        $parity = 1;
      }
    }
    if ($parity === 0) 
    {
      $month_now = date('n');
      $this->months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь'];
      for ($i = 0; $i< $month_now-1; $i++)
      {
        $item = array_shift($this->months);
        array_push ($this->months,$item);
      }
    }
    else if ($parity === 1) 
    {
      $this->months = ['Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
    } 
    return $this->months;
  }
  
  private function setMonths() 
  {

    $months = $this->getMonthsBySemester();

    $month = Request::get('month');
    
    if (!$month)
    {
      $month = $months[0];
    }

    $this->month = $month;
    return $month;
  } 
  
  public function getLessonsDays($class, $subject, $parity)
  {
    return Schedule::where('teacher', Authorization::getName())->where('class', $class)->where('lesson_name', $subject)->where('parity', $parity)->get();
  }

  public function onChangeSubject() 
  {
    $data = post();
    $subject = $data['subject'];
    $monthSelect = $data['month'];

    $month = Request::get('month');

    if (!$month)
    {
      $month = $this->setMonths();
    }

    $year = date ( 'Y' );

    switch ($month)
    {
      case 'Январь':
        $month = 1;
        break;
      case 'Февраль':
        $month = 2;
        break;
      case 'Март': 
        $month = 3;
        break;
      case 'Апрель': 
        $month = 4;
        break;
      case 'Май':
        $month = 5;
        break;
      case 'Июнь':
        $month = 6;
        break;
      case 'Сентябрь':
        $month = 9;
        $year=$year-1;
        break;
      case 'Октябрь':
        $month = 10;
        $year=$year-1;
        break;
      case 'Ноябрь': 
        $month = 11;
        $year=$year-1;
        break;
      case 'Декабрь':
        $month = 12;
        $year=$year-1;
        break;
    }

    $role = Authorization::getRole();

    $lessons_days = [];
    if ($role == 'Преподаватель') {
      $class = Request::get('group');
      if (!$class){
        $groups = $this->getGroupsForTeacher();
        $class = $groups[0]->class;
      }
      $subject_by_days = Schedule::where('teacher', Authorization::getName())->where('class', $class)->where('lesson_name', $subject)->get()->unique('day_of_week');

      $result_marks = FinalGrades::where('class', $class)->where('subject', $subject)->where('month', $monthSelect)->get();
      $result_arr = [];

      foreach ($result_marks as $mark)
      {
        array_push($result_arr, $mark->mark);
      }

    }
    else 
    {
      $class = Authorization::getClass();
      $subject_by_days = Schedule::where('class', $class)->where('lesson_name', $subject)->get()->unique('day_of_week');

      $result_marks = FinalGrades::where('class', $class)->where('subject', $subject)->where('month', $monthSelect)->get();
      $result_arr = [];

      foreach ($result_marks as $mark)
      {
        array_push($result_arr, $mark->mark);
      }
    }

    foreach ($subject_by_days as $day)
    {
      array_push($lessons_days, $day->day_of_week);
    }

    $arr = [];
    for ($index = 0; $index < count($lessons_days); $index++)
    {
      for ($i = 0; $i < count($this->days_of_week_rus); $i++)
      {
        if ($lessons_days[$index] == $this->days_of_week_rus[$i])
        {
          array_push($arr, $i);
        }
      }
    }

    $days_array = [];
    $number_of_days = cal_days_in_month(CAL_GREGORIAN,$month, $year);
    for ($x = 1; $x <= $number_of_days; $x++) {
      for ($index = 0; $index< count($arr); $index++)
      {
        
        if (date("l", strtotime($x . "-" . $month . "-" . $year)) == $this->days_of_week_eng[$arr[$index]]){

          array_push($days_array, $x);
        }
      }
    }

    $this->days = $days_array;
    if ($role == 'Преподаватель') {
      $marks = Journal::where('class', $class)->where('subject', $subject)->get();      
      $marksArr = [];
      $datesArr = [];
      foreach ($days_array as $day)
      {
        array_push($datesArr, $day.'.'.$month.'.'.$year);
      }

      foreach ($datesArr as $date)
      {
        foreach ($marks as $mark)
        {
          if (strtotime($mark->date) === strtotime($date))
          {
            array_push($marksArr, $mark->mark);
          }
        }
      }


      $addict_grades = AddictionalLessons::where('class', $class)->where('subject', $subject)->get();
      $addict_arr = [];
      foreach ($addict_grades as $addict)
      {
        $addict_month = date_parse($addict->date_lesson);
        if ($month == $addict_month['month'])
        {
          array_push($addict_arr, $addict);
        }
      }
      
      $this->getStudentsByGroup();
      $this->setMonths();
      return ['#table' => $this->renderPartial('journal/table', [
        'students'=>$this->students,
        'days'=>$this->days,
        'month'=> $this->month,
        'role'=> $role,
        'marks'=> $marksArr,
        'result_marks'=> $result_arr,
        'addict'=> $addict_arr,
        //передавать оценки из бд
      ])];
    }
    else {
      $class = Authorization::getClass();
      $marks = Journal::where('class', $class)->where('subject', $subject)->get();
      $marksArr = [];
      $datesArr = [];
      foreach ($days_array as $day)
      {
        array_push($datesArr, $day.'.'.$month.'.'.$year);
      }

      foreach ($datesArr as $date)
      {
        foreach ($marks as $mark)
        {
          if (strtotime($mark->date) === strtotime($date))
          {
            array_push($marksArr, $mark->mark);
          }
        }
      }

      
      $addict_grades = AddictionalLessons::where('class', $class)->where('subject', $subject)->get();
      $addict_arr = [];
      foreach ($addict_grades as $addict)
      {
        $addict_month = date_parse($addict->date_lesson);
        if ($month == $addict_month['month'])
        {
          array_push($addict_arr, $addict);
        }
      }
      $this->getClassmates();
      $this->setMonths();
      return ['#table' => $this->renderPartial('journal/table', [
        'students'=>$this->classmates,
        'days'=>$this->days,
        'month'=> $this->month,
        'role'=> $role,
        'marks' => $marksArr,
        'result_marks'=> $result_arr,
        'addict'=> $addict_arr,
      ])];
    }
  }

  public function onLoadPage()
  {
    $data = post();
    $subject = $data['subject'];
    $monthSelect = $data['month'];
    if (!$subject)
    {
      return false;
    }
    $month = Request::get('month');

    if (!$month)
    {
      $month = $this->setMonths();
    }

    $year = date ( 'Y' );

    switch ($month)
    {
      case 'Январь':
        $month = 1;
        break;
      case 'Февраль':
        $month = 2;
        break;
      case 'Март': 
        $month = 3;
        break;
      case 'Апрель': 
        $month = 4;
        break;
      case 'Май':
        $month = 5;
        break;
      case 'Июнь':
        $month = 6;
        break;
      case 'Сентябрь':
        $month = 9;
        $year=$year-1;
        break;
      case 'Октябрь':
        $month = 10;
        $year=$year-1;
        break;
      case 'Ноябрь': 
        $month = 11;
        $year=$year-1;
        break;
      case 'Декабрь':
        $month = 12;
        $year=$year-1;
        break;
    }

    $role = Authorization::getRole();

    $lessons_days = [];
    if ($role == 'Преподаватель') {
      $class = Request::get('group');
      if (!$class){
        $groups = $this->getGroupsForTeacher();
        $class = $groups[0]->class;
      }
      $number_of_days = cal_days_in_month(CAL_GREGORIAN,$month, $year);
      for ($x = 1; $x <= $number_of_days; $x++) {
        $parity_by_day = (new ScheduleClass)->getParity($year . "-" . $month . "-" . $x);
      }
      $subject_by_days = Schedule::where('teacher', Authorization::getName())->where('class', $class)->where('lesson_name', $subject)->get()->unique('day_of_week');

      $result_marks = FinalGrades::where('class', $class)->where('subject', $subject)->where('month', $monthSelect)->get();
      $result_arr = [];

      foreach ($result_marks as $mark)
      {
        array_push($result_arr, $mark->mark);
      }

    }
    else 
    {
      $class = Authorization::getClass();
      $subject_by_days = Schedule::where('class', $class)->where('lesson_name', $subject)->get()->unique('day_of_week');

      $result_marks = FinalGrades::where('class', $class)->where('subject', $subject)->where('month', $monthSelect)->get();
      $result_arr = [];

      foreach ($result_marks as $mark)
      {
        array_push($result_arr, $mark->mark);
      }
    }

    foreach ($subject_by_days as $day)
    {
      array_push($lessons_days, $day->day_of_week);
    }

    $arr = [];
    for ($index = 0; $index < count($lessons_days); $index++)
    {
      for ($i = 0; $i < count($this->days_of_week_rus); $i++)
      {
        if ($lessons_days[$index] == $this->days_of_week_rus[$i])
        {
          array_push($arr, $i);
        }
      }
    }

    // числа занятий по дням
    $days_array = [];
    $number_of_days = cal_days_in_month(CAL_GREGORIAN,$month, $year);
    for ($x = 1; $x <= $number_of_days; $x++) {
      for ($index = 0; $index< count($arr); $index++)
      {
        
        if (date("l", strtotime($x . "-" . $month . "-" . $year)) == $this->days_of_week_eng[$arr[$index]]){
          array_push($days_array, $x);
        }
      }
    }

    $this->days = $days_array;
    if ($role == 'Преподаватель') {
      // Получение оценок
      $marks = Journal::where('class', $class)->where('subject', $subject)->get();

      $marksArr = [];
      $datesArr = [];
      foreach ($days_array as $day)
      {
        array_push($datesArr, $day.'.'.$month.'.'.$year);
      }

      foreach ($datesArr as $date)
      {
        foreach ($marks as $mark)
        {
          if (strtotime($mark->date) === strtotime($date))
          {
            array_push($marksArr, $mark->mark);
          }
        }
      }
      
      // Дополнительные поля
      $addict_grades = AddictionalLessons::where('class', $class)->where('subject', $subject)->get();
      $addict_arr = [];
      foreach ($addict_grades as $addict)
      {
        $addict_month = date_parse($addict->date_lesson);
        if ($month == $addict_month['month'])
        {
          array_push($addict_arr, $addict);
        }
      }

      $this->getStudentsByGroup();
      $this->setMonths();
      return ['#table' => $this->renderPartial('journal/table', [
        'students'=>$this->students,
        'days'=>$this->days,
        'month'=> $this->month,
        'role'=> $role,
        'marks'=> $marksArr,
        'result_marks'=> $result_arr,
        'addict'=> $addict_arr,
      ])];
    }
    else {
      $class = Authorization::getClass();
      $marks = Journal::where('class', $class)->where('subject', $subject)->get();
      $marksArr = [];
      $datesArr = [];
      foreach ($days_array as $day)
      {
        array_push($datesArr, $day.'.'.$month.'.'.$year);
      }

      foreach ($datesArr as $date)
      {
        foreach ($marks as $mark)
        {
          if (strtotime($mark->date) === strtotime($date))
          {
            array_push($marksArr, $mark->mark);
          }
        }
      }

      
      $addict_grades = AddictionalLessons::where('class', $class)->where('subject', $subject)->get();
      $addict_arr = [];
      foreach ($addict_grades as $addict)
      {
        $addict_month = date_parse($addict->date_lesson);
        if ($month == $addict_month['month'])
        {
          array_push($addict_arr, $addict);
        }
      }
      $this->getClassmates();
      $this->setMonths();
      return ['#table' => $this->renderPartial('journal/table', [
        'students'=>$this->classmates,
        'days'=>$this->days,
        'month'=> $this->month,
        'role'=> $role,
        'marks' => $marksArr,
        'result_marks'=> $result_arr,
        'addict'=> $addict_arr,
      ])];
    }
  }
  

  
}
?>