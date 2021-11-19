<?php namespace Lazurmedia\Mgok\Models;

use Model;
use Input;

/**
 * Model
 */
class Users extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'lazurmedia_mgok_users';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
