<?php namespace LazurMedia\Mgok\FormWidgets;

use Config;
use Backend\Classes\FormWidgetBase;
use LazurMedia\Mgok\Fields;

class Classes extends FormWidgetBase
{
  public function widgetDetails()
  {
    return [
      'name' => 'Classes',
      'description' => 'Classes'
    ];
  }

  public function render() {
    $this->vars['name'] = $this->getFieldName();
    $this->vars['value'] = $this->getLoadValue();

    $this->vars['classes'] = Fields::getClasses();
    return $this->makePartial('widget');
  }
}

?>