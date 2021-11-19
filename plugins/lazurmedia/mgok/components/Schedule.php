<?php

namespace LazurMedia\Mgok\Components;

use Flash;
use Cookie;
use Redirect;
use Validator;
use ValidationException;
use Lazurmedia\Mgok\Models\Users;
use Lazurmedia\Mgok\Models\Schedule as ScheduleModel;
use Lazurmedia\Mgok\Models\ClassEvents as ClassEventsModel;
use Lazurmedia\Mgok\Models\PersonalEvents as PersonalEventsModel;
use Lazurmedia\Mgok\Components\Authorization;
use Lazurmedia\Mgok\Classes\Dates;

class Schedule extends \Cms\Classes\ComponentBase
{
  public $const = 4;
  public $dates;
  public $lessons;
  public $events;
  public $days_of_week_rus = array('Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье');
  public $days_of_week_eng = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
  public $students;

  public function componentDetails()
  {
    return [
      'name' => 'Расписание',
      'description' => 'Расписание'
    ];
  }

  public function onRun()
  {
    $this->dates = $this->getDates();
    return $this->route($this->page->url);
  }

  private function route($route)
  {
    switch ($route) {
      case '/':
        $this->renderPage();
        break;
      case '/raspisanie-klassa':
        $this->renderPage();
        break;
      case '/individualnoe-raspisanie':
        $this->renderPage();
        break;
    }
  }

  private function getDates()
  {
    $date = strtotime('monday this week');
    $dates = [];
    for ($i = 0; $i < 7; $i++) {
      $dates[] =  date("Y-m-d", strtotime('+' . $i . ' day', $date));
    }
    return $dates;
  }

  private function getParity()
  {
    $date_time_start = date_create('2020-12-21');
    $date_time_now = date_create('now');
    $interval = date_diff($date_time_start, $date_time_now);
    $amount = $interval->format('%a');
    $weeks = floor($amount / 7);
    $parity = $weeks % 2;

    if ($parity === 0) return 'По чётным неделям';
    else if ($parity === 1) return 'По нечётным неделям';
    else return 'Каждую неделю';
  }


  private function renderPage()
  {
    $user = Users::where('login', Authorization::getLogin())->first();
    for ($i = 0; $i < 7; $i++) 
    {
      $day_of_week_eng = $this->days_of_week_eng[$i]; // день недели на англ.

      // Установить для этого дня недели уроки
      if ($user->role === 'Студент') {
        $this->lessons[$day_of_week_eng] = $this->getLessonsByDay($i);
      }
      else {
        $this->lessons[$day_of_week_eng] = $this->getTeacherLessons($i);
      }

      $this->events[$day_of_week_eng]  = $this->setEvents($i);
    }
  }

  private function getLessonsByDay($index_of_day)
  {
    $parity = $this->getParity();
    $schedule_of_class = ScheduleModel::where('class', Authorization::getClass())->whereIn('parity', [$parity, 'Каждую неделю']);
    $day_of_week = $this->days_of_week_rus[$index_of_day]; // день недели
    return $schedule_of_class->where('day_of_week', $day_of_week)->get();
  }

  private function setEvents($day_of_index)
  {

    switch ($this->page->url) {
      case '/':
        $events = $this->getPersonalEvents($day_of_index);
        break;
      case '/raspisanie-klassa':
        $events = $this->getEventsByDay($day_of_index);
        break;
      case '/individualnoe-raspisanie':
        $events = $this->getPersonalEventsByStudent($day_of_index);
        break;
    }

    return $events;
  }

  private  function getEventsByDay($index_of_day)
  {
    $user = Users::where('login', Authorization::getLogin())->first();

    $date = $this->dates[$index_of_day];
    $events_class = ClassEventsModel::where('class', $user->class)->where('date', $date)->get();
    return $events_class;
  }

  // на проверку 
  private function getTeacherLessons($index_of_day, $dates = '')
  {
    $parity = $this->getParity();
    $user = Users::where('login', Authorization::getLogin())->first();
    $day_of_week = $this->days_of_week_rus[$index_of_day];

    $teacher_events = ScheduleModel::where('teacher', $user->id)->whereIn('parity', [$parity, 'Каждую неделю']);

    return $teacher_events->where('day_of_week', $day_of_week)->get();
  }

  private function getPersonalEvents($index_of_day, $dates = '')
  {
    $user = Users::where('login', Authorization::getLogin())->first();

    if ($dates === '') {
      $date = $this->dates[$index_of_day];
    } else {
      $date = $dates[$index_of_day];
    }

    $events_class = ClassEventsModel::where('class', $user->class)->where('date', $date)->get();
    $personal_events = PersonalEventsModel::where('login', $user['login'])->where('date', $date)->get();
    $merged = $events_class->merge($personal_events);
    return $merged;
  }

  private function getPersonalEventsByStudent($index_of_day, $student = '', $dates = '')
  {
    $this->students = Users::where('class', Authorization::getClass())->where('role', 'Студент')->get();

    if ($dates === '') {
      $date = $this->dates[$index_of_day];
    } else {
      $date = $dates[$index_of_day];
    }

    if ($student === '') {
      $personal_events = PersonalEventsModel::where('login', $this->students[0]['login'])->where('date', $date)->get();
    } else {
      $personal_events = PersonalEventsModel::where('login', $student)->where('date', $date)->get();
    }
    return $personal_events;
  }

  public function getScheduleForStudent($student)
  {
    $dates = $this->getDates();
    for ($i = 0; $i < 7; $i++) {
      $day_of_week_eng = $this->days_of_week_eng[$i]; // день недели на англ.

      $lessons[$day_of_week_eng] = $this->getLessonsByDay($i); // Установить для этого дня недели уроки
      $events[$day_of_week_eng]  = $this->getPersonalEventsByStudent($i, $student, $dates);
    }

    return [
      'lessons' => $lessons,
      'events' => $events,
      'dates' => $dates
    ];
  }
}
