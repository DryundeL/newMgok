<?php namespace LazurMedia\Mgok\FormWidgets;

use Config;
use Backend\Classes\FormWidgetBase;
use LazurMedia\Mgok\Fields;

class DaysWeek extends FormWidgetBase
{
  public function widgetDetails()
  {
    return [
      'name' => 'DaysWeek',
      'description' => 'DaysWeek'
    ];
  }

  public function render() {
    $this->vars['name'] = $this->getFieldName();
    $this->vars['value'] = $this->getLoadValue();

    $this->vars['days_of_week'] = Fields::getDayOfWeek();
    return $this->makePartial('widget');
  }
}

?>