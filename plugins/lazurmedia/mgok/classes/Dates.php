<?php namespace LazurMedia\Mgok\Classes;

use Request;

class Dates {
  private static $months_list = array(
    'января', 
    'февраля', 
    'марта',
    'апреля',
    'мая',
    'июня',
    'июля', 
    'августа', 
    'сентября',
    'октября', 
    'ноября', 
    'декабря'
  );

  public $days_of_week_list = array(
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday',
    'Sunday',
  );


  // ----------------------
  public $days_of_week_rus = array(
    'Понедельник', 
    'Вторник', 
    'Среда', 
    'Четверг', 
    'Пятница', 
    'Суббота', 
    'Воскресенье'
  
  );

  public $days_of_week_eng = array(
    'monday', 
    'tuesday', 
    'wednesday', 
    'thursday', 
    'friday', 
    'saturday', 
    'sunday'
  );

  public function getRusDayOfWeek($index) {
    return $this->days_of_week_rus[$index];
  }

  public function getEngDayOfWeek($index) {
    return $this->days_of_week_eng[$index];
  }

  public function getDates()
  {
    $date = strtotime('monday this week');
    $dates = [];
    $week = (int) Request::get('number_of_week');
    
    for ($i = 0 + $week * 7; $i < 7 + $week * 7; $i++) {
      $dates[] =  date("Y-m-d", strtotime('+' . $i . ' day', $date));
    }
    return $dates;
  }

  public function getParity($date)
  {
    $date_time_start = date_create('2020-12-21');
    $date_time_now = date_create($date);
    $interval = date_diff($date_time_start, $date_time_now);
    $amount = $interval->format('%a');
    $weeks = floor($amount / 7);
    $parity = $weeks % 2;

    if ($parity === 0) return 'По чётным неделям';
    else if ($parity === 1) return 'По нечётным неделям';
    else return 'Каждую неделю';
  }
  
  public function getDayOfWeek($date) {
    $day_of_week_eng = date('l', strtotime($date));
    $index_of_day = array_search($day_of_week_eng, $this->days_of_week_list);
    $day_of_week_rus = $this->days_of_week_rus[$index_of_day];
    return $day_of_week_rus;
  }
}

?>