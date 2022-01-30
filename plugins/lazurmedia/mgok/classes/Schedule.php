<?php namespace LazurMedia\Mgok\Classes;

use LazurMedia\Mgok\Classes\Dates;
use Lazurmedia\Mgok\Models\Users as UsersModel;
use Lazurmedia\Mgok\Models\Schedule as LessonsModel;
use Lazurmedia\Mgok\Models\Events as EventsModel;
use Lazurmedia\Mgok\Models\ClassEvents as ClassEventsModel;
use Lazurmedia\Mgok\Models\PersonalEvents as PersonalEventsModel;

class Schedule {

  // Расписания для студента
  public function getStudentSchedule($student) {
    $lessons = [];
    $events = [];
    $dates = [];

    // Получаем даты недели
    $dates = (new Dates)->getDates();

    foreach($dates as $i => $date) 
    {
      // день недели на англ.
      $day_of_week_eng = (new Dates)->getEngDayOfWeek($i);      

      // Устанавилваем уроки для этого дня недели
      $parity = $this->getParity($date);
      $day_of_week_rus = (new Dates)->getRusDayOfWeek($i);
      $lessons[$day_of_week_eng] = (new LessonsModel)->getClassLessons($student->class, $day_of_week_rus, $parity);
      
      // Получить классовые и персональные события этого дня
      // $class_events = (new ClassEventsModel)->getClassEvents($student->class, $date);
      // $personal_events = (new PersonalEventsModel)->getPersonalEvents($student->login, $date);
      // // Сливаем события вместе
      // $merge = $class_events->merge($personal_events);
      // // Устанавилваем события для этого дня недели
      // $events[$day_of_week_eng] = $merge;

      // Test Получить события дня
      $events[$day_of_week_eng] = (new EventsModel)->getEvents($student->login, $date);
    }

    return [
      'dates' => $dates,
      'lessons' => $lessons,
      'events' => $events,
    ];
  }

  // Расписания для учителя
  public function getTeacherSchedule($teacher) {
    if ($teacher === NULL) return false;
    
    $lessons = [];
    $class_events = [];
    $dates = [];

    // Получаем даты недели
    $dates = (new Dates)->getDates();

    foreach($dates as $i => $date) 
    {
      // день недели на англ.
      $day_of_week_eng = (new Dates)->getEngDayOfWeek($i);      

      // Установить для этого дня недели уроки
      $parity = $this->getParity($date);
      $day_of_week_rus = (new Dates)->getRusDayOfWeek($i);
      $lessons[$day_of_week_eng] = (new LessonsModel)->getTeacherLessons($teacher->full_name, $day_of_week_rus, $parity);
      
      // Установить для этого дня недели классовые события
      $class_events[$day_of_week_eng] = (new EventsModel)->getClassEvents($teacher->login, $date);
    }

    return [
      'dates' => $dates,
      'lessons' => $lessons,
      'events' => $class_events,
    ];
  }

  // Расписания для класса
  public function getClassSchedule($class) {
    $lessons = [];
    $events = [];
    $dates = [];

    // Получаем даты недели
    $dates = (new Dates)->getDates();

    foreach($dates as $i => $date) 
    {
      // день недели на англ.
      $day_of_week_eng = (new Dates)->getEngDayOfWeek($i);      

      // Устанавилваем уроки для этого дня недели
      $parity = $this->getParity($date);
      $day_of_week_rus = (new Dates)->getRusDayOfWeek($i);
      $lessons[$day_of_week_eng] = (new LessonsModel)->getClassLessons($class, $day_of_week_rus, $parity);
      
      // Получить классовые события этого дня
      $teacher = (new UsersModel)->getTeacher($class);
      $class_events = (new EventsModel)->getClassEvents($teacher->login, $date);
      // Устанавилваем события для этого дня недели
      $events[$day_of_week_eng] = $class_events;
    }

    return [
      'dates' => $dates,
      'lessons' => $lessons,
      'events' => $events,
    ];
  }

  // Расписания для кабинета
  public function getCabinetSchedule($cabinet, $address) {
    $lessons = [];

    // Получаем даты недели
    $dates = (new Dates)->getDates();

    foreach($dates as $i => $date) 
    {
      // день недели на англ.
      $day_of_week_eng = (new Dates)->getEngDayOfWeek($i);      

      // Устанавилваем уроки для этого дня недели
      $parity = $this->getParity($date);
      $day_of_week_rus = (new Dates)->getRusDayOfWeek($i);
      $lessons[$day_of_week_eng] = (new LessonsModel)->getCabinetLessons($cabinet, $address, $day_of_week_rus, $parity);
    }

    return $lessons;
  }

  public function getParity($date)
  {
    $date_time_start = date_create('2020-12-21');
    $date_time_now = date_create($date);
    $interval = date_diff($date_time_start, $date_time_now);
    $amount = $interval->format('%a');
    $weeks = floor($amount / 7);
    $parity = $weeks % 2;

    if ($parity === 0) return 'По чётным неделям';
    else if ($parity === 1) return 'По нечётным неделям';
    else return 'Каждую неделю';
  }
}
?>