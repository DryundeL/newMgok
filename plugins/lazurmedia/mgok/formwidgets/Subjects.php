<?php namespace LazurMedia\Mgok\FormWidgets;

use Config;
use Backend\Classes\FormWidgetBase;
use LazurMedia\Mgok\Fields;

class Subjects extends FormWidgetBase
{
  public function widgetDetails()
  {
    return [
      'name' => 'Subjects',
      'description' => 'Subjects'
    ];
  }

  public function render() {
    $this->vars['name'] = $this->getFieldName();
    $this->vars['value'] = $this->getLoadValue();

    $this->vars['subjects'] = Fields::getSubjects();
    return $this->makePartial('widget');
  }
}

?>