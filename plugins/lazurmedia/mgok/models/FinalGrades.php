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
}
