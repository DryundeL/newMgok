<?php namespace LazurMedia\Mgok\Components;

use Cms\Classes\ComponentBase;
use Lazurmedia\Mgok\Models\Activities as ActivitiesModal; 

class Activities extends ComponentBase { 
  public function componentDetails() 
  {
    return [
      'name' => 'Активности',
      'description' => 'Активности'
    ];
  }
  public $activities;

  public function onRun() {
    $this->activities = ActivitiesModal::all();
  }
}
?>