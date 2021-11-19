<?php namespace LazurMedia\Mgok\FormWidgets;

use Config;
use Backend\Classes\FormWidgetBase;
use LazurMedia\Mgok\Fields;

class Roles extends FormWidgetBase
{
  public function widgetDetails()
  {
    return [
      'name' => 'Roles',
      'description' => 'Roles'
    ];
  }

  public function render() {
    $this->vars['name'] = $this->getFieldName();
    $this->vars['value'] = $this->getLoadValue();

    $this->vars['roles'] = Fields::getRoles();
    return $this->makePartial('widget');
  }
}

?>