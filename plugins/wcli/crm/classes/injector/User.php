<?php

namespace Wcli\Crm\Classes\Injector;

use Backend\Controllers\Users as UsersController;
use Backend\Models\User as UserModel;
use Event;

//use Illuminate\Support\Collection;

//use \PhpOffice\PhpSpreadsheet\Shared\Date as DateConvert DateConvert::excelToDateTimeObject($row['closed_at']);;

class User
{
    public function __construct()
    {

        UserModel::extend(function ($model) {
            $model->belongsTo['region'] = ['Wcli\Crm\Models\Region', 'key' => 'crm_region_id'];
        });

        Event::listen('backend.form.extendFields', function ($widget) {

            //trace_log('yo');

            // Only for the User controller
            if (!$widget->getController() instanceof UsersController) {
                return;
            }

            // Only for the User model
            if (!$widget->model instanceof UserModel) {
                return;
            }

            $widget->addTabFields([
                'region' => [
                    'tab' => 'Crm',
                    'label' => 'wcli.crm::lang.menu.region',
                    'placeholder' => 'waka.utils::lang.global.placeholer',
                    'type' => 'relation',
                    'nameFrom' => 'name',
                ],
            ]);
        });
    }
}
