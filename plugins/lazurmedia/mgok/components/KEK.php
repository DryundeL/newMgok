<?php

namespace LazurMedia\Mgok\Components;
use Lazurmedia\Mgok\Models\Criterias;

 class KEK extends \Cms\Classes\ComponentBase
 {
  public $criterias; 
  public function componentDetails()
  {
    return [
      'name' => 'КЭК',
      'description' => 'КЭК'
    ];
  }

  public function onRun()
  {
    $this->getAllKEK();
  }


  private function getAllKEK()
  {
    return $this->criterias = Criterias::all();
  }
 }
?>