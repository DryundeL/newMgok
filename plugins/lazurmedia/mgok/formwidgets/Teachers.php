<?php namespace LazurMedia\Mgok\FormWidgets;

use Config;
use Backend\Classes\FormWidgetBase;
use LazurMedia\Mgok\Fields;

class Teachers extends FormWidgetBase
{
  public function widgetDetails()
  {
    return [
      'name' => 'Teachers',
      'description' => 'Teachers'
    ];
  }

  public function render() {
    $this->vars['name'] = $this->getFieldName();
    $this->vars['value'] = $this->getLoadValue();

    $this->vars['teachers'] = Fields::getTeachers();
    return $this->makePartial('widget');
  }
}

?>