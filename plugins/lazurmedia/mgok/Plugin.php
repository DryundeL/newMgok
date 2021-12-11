<?php namespace Lazurmedia\Mgok;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'LazurMedia\Mgok\Components\Authorization' => 'Authorization',
            'LazurMedia\Mgok\Components\Schedule' => 'Schedule',
            'LazurMedia\Mgok\Components\KEK'=> 'KEK',
            'LazurMedia\Mgok\Components\Cabinetes'=> 'Cabinetes',
            'LazurMedia\Mgok\Components\Activities'=> 'Activities',
        ];
    }

    public function registerFormWidgets() 
    {
        return [
            'LazurMedia\Mgok\FormWidgets\Roles' => 'roles',
            'LazurMedia\Mgok\FormWidgets\Cabinets' => 'cabinets',
            'LazurMedia\Mgok\FormWidgets\Teachers' => 'teachers',
            'LazurMedia\Mgok\FormWidgets\Students' => 'students',
            'LazurMedia\Mgok\FormWidgets\DaysWeek' => 'days_of_week',
            'LazurMedia\Mgok\FormWidgets\Parity' => 'parity',
            'LazurMedia\Mgok\FormWidgets\Activities' => 'activities',
        ];
    }

    public function registerSettings()
    {
    }
}
