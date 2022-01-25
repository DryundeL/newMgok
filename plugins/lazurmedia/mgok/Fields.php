<?php namespace LazurMedia\Mgok;

use Lazurmedia\Mgok\Models\Users;
use Lazurmedia\Mgok\Models\Cabinets;
use Lazurmedia\Mgok\Models\Activities;
use Lazurmedia\Mgok\Models\Schedule;

class Fields
{
  public static function getRoles() {
    return [
      'Преподаватель',
      'Ученик',
      'Директорат'
    ];
  }

  public static function getDayOfWeek() {
    return [
      'Понедельник',
      'Вторник',
      'Среда',
      'Четверг',
      'Пятница',
      'Суббота',
      'Воскресенье'
    ];
  }

  public static function getLessonNumbers() {
    return [1, 2, 3, 4, 5, 6];
  }

  public static function getParity() {
    return [
      'По чётным неделям',
      'По нечётным неделям',
      'Каждую неделю'
    ];
  }

  public static function getTeachers() {
    return Users::where('role', 'Преподаватель')->get();
  }

  public static function getStudents() {
    return Users::where('role', 'Ученик')
      ->orderBy('full_name', 'asc')
      ->get();
  }

  
  public static function getCabinets() {
    return Cabinets::all();
  }

  public static function getAddresses() {
    return [
      'Стратонавтов, 15', 
      'Волгоградский проспект, 42',
      'Лодочная, 7',
      'Старопетровкий, 1А',
      'Вишневая, 5',
    ];
  }
  
  public static function getActivities() {
    return Activities::all();
  }

  public static function getClasses() {
    return Users::where('role', 'Ученик')->get()->unique('class');
  }

  public static function getSubjects() {
    return Schedule::all()->unique('lesson_name');
  }

  public static function getLessonType() {
    return [
      'Занятие',
      'Контрольная работа',
      'Самостоятельная работа',
      'Проверочная работа',
      'Итоговая работа',
      'Полугодовая работа',
    ];
  }
}
?>