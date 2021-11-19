<?php namespace LazurMedia\Mgok\FormWidgets;

use Config;
use Backend\Classes\FormWidgetBase;
use LazurMedia\Mgok\Fields;

class Parity extends FormWidgetBase
{
  public function widgetDetails()
  {
    return [
      'name' => 'Parity',
      'description' => 'Parity'
    ];
  }

  public function render() {
    $this->vars['name'] = $this->getFieldName();
    $this->vars['value'] = $this->getLoadValue();

    $this->vars['parity_items'] = Fields::getParity();
    return $this->makePartial('widget');
  }
}

?>