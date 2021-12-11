<?php namespace Lazurmedia\Mgok\Models;

use Model;
use Validator;
use Lazurmedia\Mgok\Components\Authorization;

/**
 * Model
 */
class ClassEvents extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'lazurmedia_mgok_class_events';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    protected $guarded = false;

    public function getClassEvents($class, $date) {
        return ClassEvents::where('class', $class)
            ->where('date', $date)
            ->get();
    }

    public static function addClassEvent($data) 
    {
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
            $user = Authorization::getUser();

            $event = new ClassEvents;
            $event->teacher = $user->full_name;
            $event->class = $user->class;
            $event->event_name = $data['event_name'];
            $event->time_from = $data['time_from'];
            $event->time_to = $data['time_to'];
            $event->event_place = $data['event-input-place'];
            $event->date = $data['date'];
            $event->save();
        }        
    }
}
