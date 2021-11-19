<?php namespace LazurMedia\Mgok;

use Lazurmedia\Mgok\Models\Users;
use Lazurmedia\Mgok\Models\Cabinets;

class Fields
{
  public static function getRoles() {
    return [
      'Преподаватель',
      'Студент'
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
    return Users::where('role', 'Студент')->get();
  }
  
  public static function getCabinets() {
    return Cabinets::all();
  }
}
?>