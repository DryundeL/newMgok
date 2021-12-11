<?php namespace Lazurmedia\Mgok\Controllers;

use Input;
use BackendMenu;
use Backend\Classes\Controller;
use Lazurmedia\Mgok\Classes\Import;

class Schedule extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController',        'Backend\Behaviors\ReorderController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Lazurmedia.Mgok', 'main-menu-item', 'side-menu-item3');
    }

    public function onImport() {
        $path = './plugins/lazurmedia/mgok/controllers';
        Input::file('import')->move($path, '_import.xlsx');
        
        return Import::import('lessons');
    }
}
