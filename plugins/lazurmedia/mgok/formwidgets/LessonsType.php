<?php namespace LazurMedia\Mgok\FormWidgets;

use Config;
use Backend\Classes\FormWidgetBase;
use LazurMedia\Mgok\Fields;

class LessonsType extends FormWidgetBase
{
  public function widgetDetails()
  {
    return [
      'name' => 'LessonsType',
      'description' => 'LessonsType'
    ];
  }

  public function render() {
    $this->vars['name'] = $this->getFieldName();
    $this->vars['value'] = $this->getLoadValue();

    $this->vars['lessons_type'] = Fields::getLessonType();
    return $this->makePartial('widget');
  }
}

?>