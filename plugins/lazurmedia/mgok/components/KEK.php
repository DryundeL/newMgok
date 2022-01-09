<?php

namespace LazurMedia\Mgok\Components;
use Lazurmedia\Mgok\Models\Criterias;
use Lazurmedia\Mgok\Components\Authorization;
use Redirect;
use Cookie;
use DB;

 class KEK extends \Cms\Classes\ComponentBase
 {
  public $criterias; 
  public $results;
  public $total_results;
  public $blocks = [];
  public function componentDetails()
  {
    return [
      'name' => 'КЭК',
      'description' => 'КЭК'
    ];
  }

  public function onRun()
  {
    
    $this->getKEKByAccess();
    $this->calcResults();
    $role = Authorization::getRole();
    if ($role != 'Директорат') {
      return Redirect::to('/');
    }
  }

  
  private function getKEKByAccess()
  {
    $access = [];
    $user = Authorization::getUser();
    $access_array = explode(',' , $user->access);

    
    foreach ($access_array as $item)
    {
      if ($item === '0') {
        array_push($access, Criterias::all());
      }
      else {
        array_push($access, Criterias::where('id', $item)->get());
      }
    }

    $blocks_name = [];
    foreach ($access as $elem)
    {
      foreach ($elem as $item)
      {
        array_push($blocks_name, $item);
      }
    }


    $arr = [];
    foreach ($blocks_name as $block)
    {
      array_push($arr, $block->block);
    }

    $this->blocks = array_unique($arr);

    return $this->criterias = $access;
  }

  public function onEditKek()
  {
    $data = post();
    $blocks = [];

    foreach($data as $block)
    {
      array_push($blocks, $block);
    }
    // var_dump($blocks);
    foreach($blocks as $block)
    {
      foreach ($block as $input)
      {
        $row = Criterias::find($input['id']);
        if (isset($input['name']) && !empty($input['name']) ? $input['name'] : "")
        { 
          switch ($input['name'])
          {
            case 'mechanical_engineering_input':
              $row->mechanical_engineering_input = $input['value'];
              $row->mechanical_engineering_ball = $input['ball'];
              break;
            case 'economy_input':
              $row->economy_input = $input['value'];
              $row->economy_ball = $input['ball'];
              break;
            case 'pharmaceuticals_input':
              $row->pharmaceuticals_input = $input['value'];
              $row->pharmaceuticals_ball = $input['ball'];
              break;
            case 'it_input':
              $row->it_input = $input['value'];
              $row->it_ball = $input['ball'];
              break;
            case 'math_input':
              $row->math_input = $input['value'];
              $row->math_ball = $input['ball'];
              break;
            case 'linguistics_input':
              $row->linguistics_input = $input['value'];
              $row->linguistics_ball = $input['ball'];
              break;
            case 'earth_input':
              $row->earth_input = $input['value'];
              $row->earth_ball = $input['ball'];
              break;
            case 'foreign_input': 
              $row->foreign_input = $input['value'];
              $row->foreign_ball = $input['ball'];
              break;
            case 'health_input':
              $row->health_input = $input['value'];
              $row->health_ball = $input['ball'];
              break;
            case 'design_input':
              $row->design_input = $input['value'];
              $row->design_ball = $input['ball'];
              break;
            case 'tutor_input':
              $row->tutor_input = $input['value'];
              $row->tutor_ball = $input['ball'];
              break;
          }
        }
        
        $row->save();
      }
    }
    $this->calcResults();
    return ['#results' => $this->renderPartial('kek/result', [
      'results'=>$this->results,
      'total_results'=>$this->total_results,
    ])];
  }

  private function calcResults() {
    $this->results['block1'] = $this->sumBlock(Criterias::where('block', 1)->get());
    $this->results['block2'] = $this->sumBlock(Criterias::where('block', 2)->get());
    $this->results['block3'] = $this->sumBlock(Criterias::where('block', 3)->get());
    $this->results['block4'] = $this->sumBlock(Criterias::where('block', 4)->get());
    $this->results['block5'] = $this->sumBlock(Criterias::where('block', 5)->get());
    $this->results['block6'] = $this->sumBlock(Criterias::where('block', 6)->get());

    $this->total_results = $this->sumTotalResult($this->results);
  }
  
  private function sumBlock($criterias) {
    $names = ['mechanical_engineering', 'economy', 'pharmaceuticals', 'it', 'math', 'linguistics', 'earth', 'foreign', 'health', 'design', 'tutor'];
    $sum = [];

    foreach($criterias as $criteria) 
    {
      foreach($names as $name) {
        if ($criteria->chapter !== 'Штрафные баллы') {
          $sum[$name] = ($sum[$name] ?? 0) + $criteria["$name"."_ball"];
        } else {
          $sum[$name] = ($sum[$name] ?? 0) - $criteria["$name"."_ball"];
        }
      }
    }

    return $sum;
  }

  private function sumTotalResult($results) {
    $names = ['mechanical_engineering', 'economy', 'pharmaceuticals', 'it', 'math', 'linguistics', 'earth', 'foreign', 'health', 'design', 'tutor'];
    $total_results = [];

    foreach($results as $block) 
    {
      foreach($names as $name) {
        $total_results[$name] = ($total_results[$name] ?? 0) + $block[$name];
      }
    }

    return $total_results;
  }
}
?>
