<?php namespace LazurMedia\Mgok\FormWidgets;

use Config;
use Backend\Classes\FormWidgetBase;
use LazurMedia\Mgok\Fields;

class Students extends FormWidgetBase
{
  public function widgetDetails()
  {
    return [
      'name' => 'Students',
      'description' => 'Students'
    ];
  }

  public function render() {
    $this->vars['name'] = $this->getFieldName();
    $this->vars['value'] = $this->getLoadValue();

    $this->vars['students'] = Fields::getStudents();
    return $this->makePartial('widget');
  }
}

?>