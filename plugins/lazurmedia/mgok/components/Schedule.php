<?php

namespace LazurMedia\Mgok\Components;

use Db;
use Flash;
use Cookie;
use DateInterval;
use Redirect;
use Request;
use ValidationException;
use Input;
use Lazurmedia\Mgok\Models\Users as UsersModel;
use Lazurmedia\Mgok\Models\Schedule as ScheduleModel;
use Lazurmedia\Mgok\Models\ClassEvents as ClassEventsModel;
use Lazurmedia\Mgok\Models\Events as EventsModel;
use Lazurmedia\Mgok\Models\PersonalEvents as PersonalEventsModel;
use Lazurmedia\Mgok\Components\Authorization;
use Lazurmedia\Mgok\Classes\Dates as DatesClass;
use Lazurmedia\Mgok\Classes\Schedule as ScheduleClass;

class Schedule extends \Cms\Classes\ComponentBase
{
  public $dates;
  public $lessons;
  public $events;
  
  public $students;
  public $classes;

  public function componentDetails()
  {
    return [
      'name' => 'Расписание',
      'description' => 'Расписание'
    ];
  }

  public function onRun()
  {
    $this->dates = (new DatesClass)->getDates();
    return $this->routes($this->page->url);
  }

  public function getAbbreviatedNameByLogin($login)
  {
    $user = UsersModel::where('login', $login)->first();
    
    $full_name = $user->full_name;
    $fio = explode(' ', $full_name);
    $name = mb_substr($fio[1] ?? '',0,1,'UTF-8').'.';
    $sec_name = mb_substr($fio[2] ?? '',0,1,'UTF-8').'.';
    $full_name = implode(' ', array($fio[0], $name, $sec_name));
    return $full_name;
  }

  private function routes($route)
  {
    //redirect to KEK
    $user = Authorization::getUser();
    if($user){
      $role = $user->role;

      if ($role === 'Директорат') {
        return Redirect::to('/koefficient-effektivnosti-kafedr');
      }
    }

    switch($route) {
      case '/':
        $this->mainPage();
        break;
      case '/raspisanie-klassa':
        $this->classSchedule();
        break;
      case '/individualnoe-raspisanie':
        $this->personalSchedule();
        break;
      case '/redaktirovanie-raspisaniya':
        $this->mainPage();
        break;
    }
  }

  private function mainPage() {
    $user = Authorization::getUser();
    $role = $user->role;

    // search params
    $searchRole = Request::get('role');
    $searchText = Request::get('text');

    // if not search
    if ($searchRole === NULL || $searchText === NULL) {
      // default schedule
      if ($role === 'Преподаватель' || $role === 'Учитель')
        $schedule = (new ScheduleClass)->getTeacherSchedule($user);
      else
        $schedule = (new ScheduleClass)->getStudentSchedule($user);
    } else {
      // search schedule
      if ($searchRole === 'Преподаватель') {
        $teacher = UsersModel::where('full_name', $searchText)->first();
        $schedule = (new ScheduleClass)->getTeacherSchedule($teacher);
      } else if ($searchRole === 'Группа/класс') {
        $schedule = (new ScheduleClass)->getClassSchedule($searchText);
      } else if ($searchRole === 'Учащийся') {
        $user = UsersModel::where('full_name', $searchText)->first();
        if (!$user)
        {
          return false;
        }
        $schedule = (new ScheduleClass)->getStudentSchedule($user);
      }
    }


    [
      'dates' => $this->dates,
      'lessons' => $this->lessons,
      'events' => $this->events,
    ] = $schedule;
  }

  private function classSchedule() {
    $user = Authorization::getUser();
    $this->classes = explode(',', $user->class);
    
    // Выбираем класс преподавателя
    $selectedClass = Request::get('group');
    if ($selectedClass) {
      $schedule = (new ScheduleClass)->getClassSchedule($selectedClass);
    } else {
      $schedule = (new ScheduleClass)->getClassSchedule($this->classes[0]);
    }

    [
      'dates' => $this->dates,
      'lessons' => $this->lessons,
      'events' => $this->events,
    ] = $schedule;
  }

  private function personalSchedule() {
    $user = Authorization::getUser();
    $this->classes = explode(',', $user->class);

    // Выбираем класс преподавателя
    $selectedClass = Request::get('group');
    if ($selectedClass) {
      $this->students = (new UsersModel)->getStudentsByClass($selectedClass);
    } else {
      $this->students = (new UsersModel)->getStudentsByClass($this->classes[0]);
    }

    $student = UsersModel::where('login', Request::get('student'))->first();
    if ($student)
      $schedule = (new ScheduleClass)->getStudentSchedule($student);
    else
      $schedule = (new ScheduleClass)->getStudentSchedule($this->students->first());
    
    [
      'dates' => $this->dates,
      'lessons' => $this->lessons,
      'events' => $this->events,
    ] = $schedule;
  }

  public function onAddEvent() {
    $route = $this->page->url;

    $data = post();

    switch ($route) {
      case '/raspisanie-klassa':
        EventsModel::addClassEvent($data);
        $this->classes = Authorization::getAllClasses();
        // Выбираем класс преподавателя
        $class = Authorization::getClass();
        $schedule = (new ScheduleClass)->getClassSchedule($class);
        break;
      case '/individualnoe-raspisanie':
        $data['creater'] = Authorization::getLogin();
        EventsModel::addPersonalEvent($data);
        $student = UsersModel::where('login', $data['student'])->first();
        $schedule = (new ScheduleClass)->getStudentSchedule($student);
        break;
      case '/redaktirovanie-raspisaniya':
        EventsModel::addPersonalEvent($data);
        $student = Authorization::getUser();
        $schedule = (new ScheduleClass)->getStudentSchedule($student);
    }

    return ['#schedule' => $this->renderPartial('schedule/schedule-edit', [
      'lessonsArr' => $schedule['lessons'],
      'eventsArr' => $schedule['events'],
      'dates' => $schedule['dates'],
    ])];
  }

  // -- -- gets -- -- //

  public function getStudentScheduleByLogin($login) {
    $student = UsersModel::where('login', $login)->first();
    $schedule = (new ScheduleClass)->getStudentSchedule($student);
    return $schedule;
  }


  // -- -- onFunctions -- -- //
  public function onPromptSearch() {
    $data = post();

    $type = $data['type'];
    $text = $data['text'];

    if ($type === 'Преподаватель') {
      $records = Db::table('lazurmedia_mgok_users')
        ->select('full_name')
        ->where('role', 'Преподаватель')
        ->where('full_name', 'like', "%$text%")
        ->take(5)
        ->get();

      return $records;
    } else if ($type === 'Группа/класс') {
      $records = Db::table('lazurmedia_mgok_users')
        ->select('class')
        ->where('class', 'like', "%$text%")
        ->where('role', 'Ученик')
        ->distinct()
        ->take(5)
        ->get();

      return $records;
    } else if ($type === 'Учащийся') {
      $records = Db::table('lazurmedia_mgok_users')
        ->select('full_name')
        ->where('role', 'Ученик')
        ->where('full_name', 'like', "%$text%")
        ->take(5)
        ->get();

      return $records;
    }
  }

  public function onDeleteEvent() {
    $event = post('event');

    // if (Authorization::getRole() == 'Преподаватель' || Authorization::getRole() == 'Учитель') {
    if ($event['event_class'] == true) {
      // if class event
      $route = $this->page->url;

      if ($route === '/individualnoe-raspisanie') {
        // Удалить у одного ученика
        $class_event = EventsModel::find($event['id']);
        $class_event->delete();
      } else {
        // Удалить у всех событе класса
        $this->fullDeleteClassEvent($event);
      }
    } else  {
      // if personal event
      $class_event = EventsModel::find($event['id']);
      $class_event->delete();
    }
    // } else {
    //   return false;
    // } 
  }

  private function fullDeleteClassEvent($event) {
    $teacher = UsersModel::where('login', $event['creater'])->first();
    $classes = explode(',', $teacher->class);
    // Выбираем класс преподавателя
    $selectedClass = Request::get('group');
    if ($selectedClass) {
      $this->students = (new UsersModel)->getStudentsByClass($selectedClass);
      $students = (new UsersModel)->getStudentsByClass($selectedClass);
    } else {
      $students = (new UsersModel)->getStudentsByClass($classes[0]);
    }

    foreach($students as $student) {
      $classEvent = EventsModel::where('login', $student->login)
        ->where('creater', $teacher->login)
        ->where('date', $event['date'])
        ->where('event_name', $event['event_name'])
        ->where('time_from', $event['time_from'])
        ->where('time_to', $event['time_to'])
        ->where('created_at', $event['created_at'])
        ->first();

      if (isset($classEvent)) {
        $classEvent->delete();
      }
    }
  }
}
