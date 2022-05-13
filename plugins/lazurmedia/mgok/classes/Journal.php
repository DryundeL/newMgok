<?php namespace LazurMedia\Mgok\Classes;

use LazurMedia\Mgok\Classes\Dates;
use Lazurmedia\Mgok\Models\Users as UsersModel;
use Lazurmedia\Mgok\Models\Schedule as LessonsModel;
use Lazurmedia\Mgok\Models\Events as EventsModel;
use Lazurmedia\Mgok\Models\ClassEvents as ClassEventsModel;
use Lazurmedia\Mgok\Models\PersonalEvents as PersonalEventsModel;

class Journal {
  public static function getGroupsByTeacher($teacher_name) {
    return LessonsModel::where('teacher', $teacher_name)
      ->get()
      ->unique('class');
  }	

  public static function getSubjectsForTeacher($teacher_name, $group) {
    return LessonsModel::where('teacher', $teacher_name)
      ->where('class', $group)
      ->get()
      ->unique('lesson_name');
  }	

  public static function getSubjectsForStudent($group) {
    return LessonsModel::where('class', $group)
      ->get()
      ->unique('lesson_name');
  }	

  public static function getStudentsByGroup($group) {
    return UsersModel::where('class', $group)
      ->where('role', 'Студент')
      ->get()
      ->sortBy('full_name');
  }

  public static function getSubjectsForModer($group) {
    return LessonsModel::where('class', $group)
      ->get()
      ->unique('lesson_name');
  }
}
