<?php namespace Lazurmedia\Mgok\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Lazurmedia\Mgok\Classes\Export;
use Redirect;


class FinalGrades extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController',        'Backend\Behaviors\ReorderController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Lazurmedia.Mgok', 'main-menu-item', 'side-menu-item10');
    }

    public function onExport() { 
        Export::exportFinalGrades('final_grades');
        return Redirect::to('downloadexports');
    }
}
