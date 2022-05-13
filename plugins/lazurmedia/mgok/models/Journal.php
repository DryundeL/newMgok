<?php namespace Lazurmedia\Mgok\Models;

use Log;
use Model;

/**
 * Model
 */
class Journal extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'lazurmedia_mgok_journal';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function createMark($group, $subject, $mark) {
        $journal = $this->findMark($group, $subject, $mark);

        if (!$journal) {
            Log::info("Add mark: G:$group SUB:$subject M:$mark[mark] STU: $mark[fio] D:$mark[date] NL: $mark[numberLesson]");
            $journal = new Journal;
            $journal->class = $group;
            $journal->subject = $subject;
            $journal->student = $mark['fio'];
            $journal->mark = $mark['mark'];
            $journal->date = $mark['date'];
            $journal->number_lesson = $mark['numberLesson'];
            $journal->save();
        } else {
            if ($mark['mark'] === '') {
                Log::info("Delete mark: G:$group SUB:$subject M:$mark[mark] STU: $mark[fio] D:$mark[date] NL: $mark[numberLesson]");
                $journal->delete();
            } else {
                Log::info("Update mark: G:$group SUB:$subject M:$mark[mark] STU: $mark[fio] D:$mark[date] NL: $mark[numberLesson]");
                $journal->mark = $mark['mark'];
                $journal->save();
            }
        }
    }

    private function findMark($group, $subject, $mark) {
        return Journal::where('class', $group)
            ->where('subject', $subject)
            ->where('date', $mark['date'])
            ->where('student', $mark['fio'])
            ->where('number_lesson', $mark['numberLesson'])
            ->first();
    }

    public static function getClassMarksByDay($group, $lesson, $number_lesson, $date) {
        // $test = count(Journal::where('class', $group)->where('subject', $lesson)->where('date', $date)->where('number_lesson', $number_lesson)->get());
        // var_dump($group, $lesson, $date, $test, "<br>");
        // var_dump(, "<br>");
        return Journal::where('class', $group)
            ->where('subject', $lesson)
            ->where('date', $date)
            ->where('number_lesson', $number_lesson)
            ->get()
            ->sortBy('student');
    }
}
