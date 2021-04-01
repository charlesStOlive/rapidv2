<?php namespace Wcli\Crm;

use Backend;
use Lang;
use October\Rain\Database\Relations\Relation;
use System\Classes\PluginBase;

/**
 * crm Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    //
    public $require = [
        'Toughdeveloper.Imageresizer',
        'Waka.Utils',
        'Waka.ImportExport',
        'Waka.Informer',
        'Waka.Worder',
        'Waka.Pdfer',
        'Waka.Mailtoer',
    ];
    //
    public function pluginDetails()
    {
        return [
            'name' => 'crm',
            'description' => 'No description provided yet...',
            'author' => 'waka',
            'icon' => 'icon-handshake-o',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        $inject = new \Wcli\Crm\Classes\Injector\User();

        Relation::morphMap([
            'client' => 'Wcli\Crm\Models\Client',
            'sale' => 'Wcli\Crm\Models\Sale',
            'region' => 'Wcli\Crm\Models\Region',
        ]);
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'wcli.crm.user.admin' => [
                'tab' => 'Waka CRM',
                'label' => 'Administrateur de CRM',
            ],
            'wcli.crm.user.manager' => [
                'tab' => 'Waka CRM',
                'label' => 'Manager de CRM',
            ],
            'wcli.crm.user' => [
                'tab' => 'Waka CRM',
                'label' => 'Utilisateur de CRM',
            ],
            'wcli.crm.reader' => [
                'tab' => 'Waka CRM',
                'label' => 'Peut lire mais pas modifier CRM',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'crm' => [
                'label' => Lang::get('wcli.crm::lang.menu.title'),
                'url' => Backend::url('wcli/crm/clients'),
                'icon' => 'icon-handshake-o',
                'permissions' => ['wcli.crm.*'],
                'order' => 001,
                'sideMenu' => [
                    'side-menu-clients' => [
                        'label' => Lang::get('wcli.crm::lang.menu.clients'),
                        'icon' => 'icon-building',
                        'url' => Backend::url('wcli/crm/clients'),
                        'permissions' => ['wcli.crm.*'],
                    ],
                    'side-menu-regions' => [
                        'label' => Lang::get('wcli.crm::lang.menu.regions'),
                        'icon' => 'icon-map',
                        'url' => Backend::url('wcli/crm/regions'),
                        'permissions' => ['wcli.crm.user.*'],
                    ],
                    'side-menu-sales' => [
                        'label' => Lang::get('wcli.crm::lang.menu.sales'),
                        'icon' => 'icon-money',
                        'url' => Backend::url('wcli/crm/sales'),
                        'permissions' => ['wcli.crm.*'],
                    ],
                    'side-menu-gammes' => [
                        'label' => Lang::get('wcli.crm::lang.menu.gammes'),
                        'icon' => 'icon-users',
                        'url' => Backend::url('wcli/crm/gammes'),
                        'permissions' => ['wcli.crm.user.*'],
                    ],
                ],
            ],
        ];
    }
}
