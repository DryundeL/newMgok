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
      $events_of_date = (new EventsModel)->getEvents($student->login, $date);
      $day_of_week = (new Dates)->days_of_week_rus[date('w', strtotime($date))];
      $events_of_day = (new EventsModel)->getEventByDay($student->login, $day_of_week);

      $events[$day_of_week_eng] = $events_of_date->merge($events_of_day)->sortBy('time_from');
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
      $classes = explode(',', $teacher->class);
      $classesEvents = collect();
      foreach ($classes as $class) {
        $class_events_by_date = (new EventsModel)->getClassEvents($teacher->login, $date, $class);
        $day_of_week = (new Dates)->days_of_week_rus[date('w', strtotime($date))];
        $events_by_day = (new EventsModel)->getClassEventsByDay($teacher->login, $day_of_week, $class);

        $merged_events = $class_events_by_date->merge($events_by_day)->sortBy('time_from');
        $classesEvents = $classesEvents->merge($merged_events);
      }
      $class_events[$day_of_week_eng] = $classesEvents;
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
      // var_dump($class);
      if ($teacher == null)
      {
        $events[$day_of_week_eng] = null;
      }
      else
      {
        $class_events_by_date = (new EventsModel)->getClassEvents($teacher->login, $date, $class);
        $day_of_week = (new Dates)->days_of_week_rus[date('w', strtotime($date))];
        $events_by_day = (new EventsModel)->getClassEventsByDay($teacher->login, $day_of_week, $class);

        $merged_events = $class_events_by_date->merge($events_by_day)->sortBy('time_from');
        // Устанавилваем события для этого дня недели
        $events[$day_of_week_eng] = $merged_events;
      }
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
    $date_time_start = date_create('2022-01-10');
    $date_time_now = date_create($date);
    $interval = date_diff($date_time_start, $date_time_now);
    $amount = $interval->format('%a');
    $weeks = floor($amount / 7);
    $parity = $weeks % 2;

    if ($parity === 0) return 'По нечётным неделям';
    else if ($parity === 1) return 'По чётным неделям';
    else return 'Каждую неделю';
  }
}
?>