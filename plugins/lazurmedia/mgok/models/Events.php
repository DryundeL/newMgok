<?php namespace Lazurmedia\Mgok\Models;

use Model;
use Validator;
use LazurMedia\Mgok\Fields;
use Lazurmedia\Mgok\Components\Authorization;
use Lazurmedia\Mgok\Models\Users as UsersModel;
/**
 * Model
 */
class Events extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'lazurmedia_mgok_events';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getEvents($student_login, $date) {
        return Events::where('login', $student_login)
            ->where('date', $date)
            ->get();
    }

    public function getClassEvents($teacher_login, $date) {
        return Events::where('creater', $teacher_login)
            ->where('date', $date)
            ->get()
            ->unique('created_at');
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
            $event = new Events;
            $event->login = $data['student'] ?? Authorization::getLogin();
            $event->event_name = $data['event_name'];
            $event->time_from = $data['time_from'];
            $event->time_to = $data['time_to'];
            $event->event_place = $data['event-input-place'];
            $event->date = $data['date'];
            $event->creater = $data['creater'] ?? Authorization::getLogin();
            $event->save();
        }
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
            $class = Authorization::getClass();

            $students = UsersModel::where('class', $class)->where('role', 'Ученик')->get();

            foreach($students as $student) {
                $event = new Events;
                $event->login = $student->login;
                $event->creater = $data['creater'] ?? Authorization::getLogin();
                $event->event_name = $data['event_name'];
                $event->time_from = $data['time_from'];
                $event->time_to = $data['time_to'];
                $event->event_place = $data['event-input-place'];
                $event->date = $data['date'];
                $event->event_class = true;
                $event->save();
            }

        }
    }
}
