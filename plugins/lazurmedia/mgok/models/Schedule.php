<?php namespace Lazurmedia\Mgok\Models;

use Model;

/**
 * Model
 */
class Schedule extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'lazurmedia_mgok_schedule';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    protected $guarded = false;

    public function getClassLessons($class, $day_of_week, $parity) {
        return Schedule::where('class', $class)
            ->where('day_of_week', $day_of_week)
            ->whereIn('parity', [$parity, 'Каждую неделю'])
            ->orderBy('number_lesson', 'asc')
            ->get();
    }

    public function getTeacherLessons($teacher_full_name, $day_of_week, $parity) {
        return Schedule::where('teacher', $teacher_full_name)
            ->where('day_of_week', $day_of_week)
            ->whereIn('parity', [$parity, 'Каждую неделю'])
            ->orderBy('number_lesson', 'asc')
            ->get();
    }

    public function getCabinetLessons($cabinet, $address, $day_of_week, $parity) {
        return Schedule::where('cabinet', $cabinet)
            ->where('address', $address)
            ->where('day_of_week', $day_of_week)
            ->whereIn('parity', [$parity, 'Каждую неделю'])
            ->orderBy('number_lesson', 'asc')
            ->get();
    }

    public function getLessonByDay($class, $day_of_week, $parity, $lesson_name) {
        $lesson = Schedule::where('class', $class)
            ->where('day_of_week', $day_of_week)
            ->whereIn('parity', [$parity, 'Каждую неделю'])
            ->where('lesson_name', $lesson_name)
            ->get();

        return $lesson;
    }
}
