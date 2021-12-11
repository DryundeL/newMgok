<?php namespace Lazurmedia\Mgok\Models;

use Model;
use Validator;
use LazurMedia\Mgok\Fields;
use Lazurmedia\Mgok\Components\Authorization;

/**
 * Model
 */
class PersonalEvents extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'lazurmedia_mgok_personal_events';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    protected $guarded = false;

    public function getPersonalEvents($student_login, $date) {
        return PersonalEvents::where('login', $student_login)
            ->where('date', $date)
            ->get();
    }

    public static function addPersonalEvent($data) 
    {
        $activities = Fields::getActivities()->map(function ($item, $key) { return $item->activity_name;})->toArray();
        if (!in_array($data['event_name'], $activities)) return false;

        $rules = [
            'time_from' => 'required|date_format:H:i',
            'time_to' => 'required|date_format:H:i|after:time_from',
            'event_name' => 'required',
            'event-input-place' => 'required',
        ];

        $validator = Validator::make($data, $rules);

        if($validator->fails()) {
            throw new ValidationException($validator);
        } else {
            $event = new PersonalEvents;
            $event->login = $data['student'] ?? Authorization::getLogin();
            $event->event_name = $data['event_name'];
            $event->time_from = $data['time_from'];
            $event->time_to = $data['time_to'];
            $event->event_place = $data['event-input-place'];
            $event->date = $data['date'];          
            $event->creater = $data['creater'] ?? Authorization::getFullName();
            $event->save();
        }        
    }
}
