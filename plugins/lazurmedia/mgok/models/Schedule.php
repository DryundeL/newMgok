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
}
