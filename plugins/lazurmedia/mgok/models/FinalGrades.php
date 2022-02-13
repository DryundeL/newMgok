<?php namespace Lazurmedia\Mgok\Models;

use Model;

/**
 * Model
 */
class FinalGrades extends Model
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
    public $table = 'lazurmedia_mgok_final_grades';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getFinalMarks($group, $subject, $month)
    {
        return FinalGrades::where('class', $group)
            ->where('subject', $subject)
            ->where('month', $month)
            ->get();
    }

    public function createFinalMark($group, $subject, $final) {
        $journal = $this->findFinalMark($final);
        // var_dump(!$journal, $addictive['mark']);
        if (!$journal) {
            $journal = new FinalGrades;
            $journal->class = $group;
            $journal->subject = $subject;
            $journal->student = $final['fio'];
            $journal->mark = $final['mark'];
            $journal->month = $final['month'];
            $journal->save();
        } else {
            $journal->mark = $final['mark'];
            $journal->save();
        }
    }

    private function findFinalMark($final) {
        return FinalGrades::where('month', $final['month'])
            ->where('student', $final['fio'])
            ->first();
    }
}
