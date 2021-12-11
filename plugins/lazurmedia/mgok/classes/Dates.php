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

  private static $days_of_week_list = array(
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
}

?>