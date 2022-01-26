<?php

namespace LazurMedia\Mgok\Components;

use Lazurmedia\Mgok\Components\Authorization;
use Lazurmedia\Mgok\Models\Journal;
use Lazurmedia\Mgok\Models\FinalGrades;
use Lazurmedia\Mgok\Models\AddictionalLessons;
use Lazurmedia\Mgok\Models\Schedule;
use Lazurmedia\Mgok\Models\Users;
use Request;

class ELjournal extends \Cms\Classes\ComponentBase
{
  public $subjects;
  public $lessons;

  public $marks;

  public $classes;

  public $role;

  public $classmates;
  public $students;

  public $semesters = [1, 2];
  public $months = [];

  public $month;
  public $days;

  public $days_of_week_rus = array(
    'Понедельник', 
    'Вторник', 
    'Среда', 
    'Четверг', 
    'Пятница', 
  );
  public $days_of_week_eng = array(
    'Monday', 
    'Tuesday', 
    'Wednesday', 
    'Thursday', 
    'Friday', 
  );

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
    return $this->routes($this->role);
  }

  private function routes($role) 
  { 
    switch($role)
    {
      case 'Ученик':
        $this->getSubjectsForStudent();
        $this->getClassmates();
        $this->getMonthsBySemester();
        $this->setMonths();
      case 'Преподаватель':
        $this->getGroupsForTeacher();
        $this->getStudentsByGroup();
        $this->getSubjectsForTeacher();
        $this->getMonthsBySemester();
        $this->setMonths();
    }
  }

  private function getSubjectsForStudent() 
  {
    $class = Authorization::getClass();
    $this->subjects = Schedule::where('class', $class)->get()->unique('lesson_name');
  }

  private function getSubjectsForTeacher() 
  {
    $role = Authorization::getRole();
    if ($role =='Преподаватель') {
      $class = Request::get('group');
      $teacher = Authorization::getName();
      if (!$class){
        $groups = $this->getGroupsForTeacher();
        $class = $groups[0]->class;

      }
      $this->lessons = Schedule::where('class', $class)->where('teacher', $teacher)->get()->unique('lesson_name');
    }
  }

  private function getClassmates() 
  {
    $class = Authorization::getClass();
    $classmates = Users::where('class', $class)->where('role', 'Ученик')->get()->sortBy('full_name');
    $this->classmates = $classmates;

  }

  private function getGroupsForTeacher() 
  {
    $classes = Schedule::where('teacher', Authorization::getName())->get()->unique('class');
    $this->classes = $classes;
    return $classes;
  }

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
    if ($parity === 0) $this->months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь'];
    else if ($parity === 1) $this->months = ['Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
    return $parity;
  }
  
  private function setMonths() 
  {

    $parity = $this->getMonthsBySemester();

    $month = Request::get('month');

    
    if (!$month){
      if ($parity == 1) {
        $month = 'Сентябрь';
      }
      else {
        $month = 'Январь';
      }  
    }
    $this->month = $month;
    return $month;
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

  public function onSaveMarks() 
  { 
    $data = post();
    $names = $data['data'];
    $marks = $data['marks'];
    $final_grades = $data['finalGrades'];
    
    
    for ($i = 0; $i < count($names); $i++){

      if (Journal::where('class', $names[$i]['group'])->where('subject', $names[$i]['subject'])->where('student', $names[$i]['name'])->where('date', $names[$i]['date'])->doesntExist())
      {
        $journal = new Journal;
        $journal->class = $names[$i]['group'];
        $journal->subject = $names[$i]['subject'];
        $journal->student = $names[$i]['name'];
        $journal->mark = $marks[$i]['mark'];
        $journal->date = $names[$i]['date'];
        $journal->save();
      }
      else 
      {
        $student = Journal::where('class', $names[$i]['group'])->where('subject', $names[$i]['subject'])->where('student', $names[$i]['name'])->where('date', $names[$i]['date'])->first();
        $student->mark = $marks[$i]['mark'];
        $student->save();
      }

      
    }

    for ($i = 0; $i < count($final_grades); $i++){

      if (FinalGrades::where('class', $names[$i]['group'])->where('subject', $names[$i]['subject'])->where('student', $names[$i]['name'])->where('month', $final_grades[$i]['month'])->doesntExist())
      {
        $final = new FinalGrades;
        $final->class = $names[$i]['group'];
        $final->subject = $names[$i]['subject'];
        $final->month = $final_grades[$i]['month'];
        $final->student = $names[$i]['name'];
        $final->mark = $final_grades[$i]['mark'];
        $final->save();
      }
      else 
      {
        $student = FinalGrades::where('class', $names[$i]['group'])->where('subject', $names[$i]['subject'])->where('student', $names[$i]['name'])->where('month', $final_grades[$i]['month'])->first();
        $student->mark = $final_grades[$i]['mark'];
        $student->save();
      }

    }

    if (isset($data['addictive']))
    {
      $addictive_marks = $data['addictive'];
      for ($i = 0; $i < count($addictive_marks); $i++)
      {
        if (AddictionalLessons::where('class', $names[$i]['group'])->where('subject', $names[$i]['subject'])->where('student', $names[$i]['name'])->where('name_lesson', $addictive_marks[$i]['name'])->where('date_lesson', $addictive_marks[$i]['date'])->doesntExist())
        {
          $addictive = new AddictionalLessons;
          $addictive->name_lesson = $addictive_marks[$i]['name'];
          $addictive->date_lesson = $addictive_marks[$i]['date'];
          $addictive->student = $names[$i]['name'];
          $addictive->mark = $addictive_marks[$i]['mark'];
          $addictive->class = $names[$i]['group'];
          $addictive->subject = $names[$i]['subject'];
          $addictive->save();
        }
        else 
        {
          $addict = AddictionalLessons::where('class', $names[$i]['group'])->where('subject', $names[$i]['subject'])->where('student', $names[$i]['name'])->where('name_lesson', $addictive_marks[$i]['name'])->where('date_lesson', $addictive_marks[$i]['date'])->first();
          $addict->mark = $addictive_marks[$i]['mark'];
          $addict->save();
        }
      }
    }

  }

  public function onDeleteAddict()
  {
    $data = post();
    $name_addict = $data['name'];
    $date_addict = $data['date'];
    $addict_marks = $data['marks'];
    $students = $data['surnames'];

      for ($i = 0; $i < count($students); $i++){
        $addict = AddictionalLessons::where('student', $students[$i])->where('name_lesson',  $name_addict)->where('date_lesson', $date_addict)->where('mark', $addict_marks[$i])->first();
        $addict->delete();
      }

      return back();
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
  

  
}
?>