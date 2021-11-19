<?php namespace LazurMedia\Mgok\FormWidgets;

use Config;
use Backend\Classes\FormWidgetBase;
use LazurMedia\Mgok\Fields;

class Cabinets extends FormWidgetBase
{
  public function widgetDetails()
  {
    return [
      'name' => 'Cabinets',
      'description' => 'Cabinets'
    ];
  }

  public function render() {
    $this->vars['name'] = $this->getFieldName();
    $this->vars['value'] = $this->getLoadValue();

    $this->vars['cabinets'] = Fields::getCabinets();
    return $this->makePartial('widget');
  }
}

?>