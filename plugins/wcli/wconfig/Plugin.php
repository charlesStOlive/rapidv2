<?php namespace Wcli\Wconfig;

use Backend;
use System\Classes\CombineAssets;
use System\Classes\PluginBase;

/**
 * Wconfig Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Wconfig',
            'description' => 'Config de base client',
            'author' => 'Waka',
            'icon' => 'icon-leaf',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        CombineAssets::registerCallback(function ($combiner) {
            $combiner->registerBundle('$/waka/wconfig/assets/css/simple_grid/email.less');
            $combiner->registerBundle('$/waka/wconfig/assets/css/simple_grid/pdf.less');
        });

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {
            //trace_log('coucou du shedule');
        })->everyMinute();

        //Sauvegarde de la base de données.
        $schedule->command('backup:run')->twiceDaily(0, 13);
        $schedule->command('backup:clean')->dailyAt('00:05');
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Wcli\Wconfig\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'waka.wconfig.some_permission' => [
                'tab' => 'Wconfig',
                'label' => 'Some permission',
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
        return []; // Remove this line to activate

        return [
            'wconfig' => [
                'label' => 'Wconfig',
                'url' => Backend::url('waka/wconfig/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['waka.wconfig.*'],
                'order' => 500,
            ],
        ];
    }
}
