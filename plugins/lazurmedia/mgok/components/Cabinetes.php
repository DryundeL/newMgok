<?php

namespace LazurMedia\Mgok\Components;

use Lazurmedia\Mgok\Models\Cabinets; 
use Lazurmedia\Mgok\Models\Schedule;
use Lazurmedia\Mgok\Classes\Schedule as ScheduleClass;

class Cabinetes extends \Cms\Classes\ComponentBase
{

  public $concantenated;
  public $lessons;
  public $dates;
  public $days_of_week_rus = array('Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница');
  public $days_of_week_eng = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday');

  public function componentDetails()
  {
    return [
      'name' => 'Загруженность кабинетов',
      'description' => 'Загруженность кабинетов'
    ];
  }

  public function onSearchCabinetSchedule() {
    $cabinet = post('cabinet');
    $address = post('address');
    
    $lessons = (new ScheduleClass)->getCabinetSchedule($cabinet, $address);
    return['#loadCabinets' => $this->renderPartial('cabinets/days', [
      'lessons' => $lessons, 
    ])];
  }

}
?>