<?php namespace Lazurmedia\Mgok\Models;

use Model;

/**
 * Model
 */
class AddictionalLessons extends Model
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
    public $table = 'lazurmedia_mgok_addictional_lessons';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function createAddictiveMark($group, $subject, $addictive) {
        $journal = $this->findAddictiveMark($addictive);
        // var_dump(!$journal, $addictive['mark']);
        if (!$journal) {
            $journal = new AddictionalLessons;
            $journal->class = $group;
            $journal->subject = $subject;
            $journal->student = $addictive['fio'];
            $journal->mark = $addictive['mark'];
            $journal->date_lesson = $addictive['date'];
            $journal->name_lesson = $addictive['event'];
            $journal->unique_id = $addictive['unique_id'];
            $journal->save();
        } else {
            $journal->mark = $addictive['mark'];
            $journal->date_lesson = $addictive['date'];
            $journal->name_lesson = $addictive['event'];
            $journal->save();
        }
    }

    private function findAddictiveMark($addictive) {
        return AddictionalLessons::where('unique_id', $addictive['unique_id'])
            ->where('student', $addictive['fio'])
            ->first();
    }

    public function deleteMarks($uniqueId){
        AddictionalLessons::where('unique_id', $uniqueId)->delete();
    }
}
