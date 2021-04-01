<?php namespace Wcli\Crm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Sale Back-end Controller
 */
class Sales extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Waka.ImportExport.Behaviors.ExcelImport',
        'Waka.ImportExport.Behaviors.ExcelExport',

    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Wcli.Crm', 'crm', 'side-menu-sales');
    }

    public function listExtendQuery($query)
    {
        if ($this->user->hasAccess('wcli.crm.user.*')) {
            $query;
        } elseif ($this->user->hasAccess('wcli.crm.user')) {
            if (!$this->user->region) {
                throw new \ApplicationException("Vous n'avez pas de région configuré ! contactez un administrateur");
                $query = [];
            } else {
                $regionId = $this->user->region->id;
                $query->whereHas('client', function ($q) use ($regionId) {
                    $q->where('region_id', $regionId);
                });
            }
        }
    }

}
