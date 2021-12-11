<?php namespace LazurMedia\Mgok\FormWidgets;

use Config;
use Backend\Classes\FormWidgetBase;
use LazurMedia\Mgok\Fields;

class Activities extends FormWidgetBase
{
  public function widgetDetails()
  {
    return [
      'name' => 'Activities',
      'description' => 'Activities'
    ];
  }

  public function render() {
    $this->vars['name'] = $this->getFieldName();
    $this->vars['value'] = $this->getLoadValue();

    $this->vars['activities'] = Fields::getActivities();
    return $this->makePartial('widget');
  }
}

?>