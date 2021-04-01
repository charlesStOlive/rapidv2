<?php namespace Wcli\Crm\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Client Back-end Controller
 */
class Clients extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Waka.Utils.Behaviors.BtnsBehavior',
        'Backend.Behaviors.RelationController',
        'Waka.Utils.Behaviors.PopupActions',
        'Waka.Worder.Behaviors.WordBehavior',
        'Waka.Pdfer.Behaviors.PdfBehavior',
        'Waka.Mailer.Behaviors.MailBehavior',
        'Waka.Mailtoer.Behaviors.MailtoBehavior',
        'Waka.ImportExport.Behaviors.ExcelImport',
        'Waka.ImportExport.Behaviors.ExcelExport',
        'Waka.Segator.Behaviors.CalculTags',
        'Waka.Agg.Behaviors.AggCreator',
    ];
    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $btnsConfig = 'config_btns.yaml';
    public $relationConfig = 'config_relation.yaml';
    //FIN DE LA CONFIG AUTO

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Wcli.Crm', 'crm', 'side-menu-clients');
    }

    public function listFilterExtendScopes($filter)
    {
        if ($this->user->role == 'commercial_user') {
            $filter->removeScope('region');
        }

    }

    public function listExtendQuery($query)
    {
        if ($this->user->hasAccess('wcli.crm.user.*')) {
            $query;
        } elseif ($this->user->hasAccess('wcli.crm.user')) {
            if (!$this->user->region) {
                throw new \ApplicationException("Vous n'avez pas de région configuré ! contactez un administrateur");
                $query;
            } else {
                $regionId = $this->user->region->id;
                $query->where('region_id', $regionId);
            }
        }
    }

}
