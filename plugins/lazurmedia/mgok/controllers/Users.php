<?php namespace Lazurmedia\Mgok\Controllers;

use Input;
use Cookie;
use Redirect;
use BackendMenu;
use Backend\Classes\Controller;
use Lazurmedia\Mgok\Classes\Import;
use Lazurmedia\Mgok\Classes\Export;

class Users extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController',        'Backend\Behaviors\ReorderController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Lazurmedia.Mgok', 'main-menu-item', 'side-menu-item');
    }

    public function onImport() {
        $path = './plugins/lazurmedia/mgok/controllers';
        Input::file('import')->move($path, '_import.xlsx');
        
        return Import::import('users');
    }

    public function onExport() { 
        Export::export('users');
        return Redirect::to('downloadexports');
    }

    public function onSignIn() {
        $data = post()['Users'];
        Cookie::queue('mgok_auth', $data['login'], 43800);
    }
}
