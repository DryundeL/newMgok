<?php namespace LazurMedia\Mgok\Classes;

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

  public static function getNumberDayInWeek() {
    $month = self::$months_list[date('m')];
    
    $current_day_of_week = date('l');
    
    return array_search($current_day_of_week, self::$days_of_week_list);
  }

  public static function getCurrentMonth() {
    $month = date('m') - 1;
    return self::$months_list[$month];
  }

  public static function getPreviousMonth() {
    $month = date('m') - 1;
    return self::$months_list[$month - 1];
  }

  public static function getNextMonth() {
    $month = date('m') - 1;
    return self::$months_list[$month + 1];
  }

  public static function getMonthIndex($month) {
    return array_search($month, self::$months_list);
  }
}

?>