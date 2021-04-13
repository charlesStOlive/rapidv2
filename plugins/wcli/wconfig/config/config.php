<?php

return [
    'dataSource' => [
        'src' => 'wcli/wconfig/config/datasources.yaml',
    ],
    'workflows' => [
        // '/waka/crm/config/project_w.yaml',
        // '/waka/tasker/config/task_w.yaml',
    ],
    'start_data' => [
        'ventes_2019' => [
            'class' => '\Wcli\Crm\Classes\Imports\SalesImport',
            'table' => 'wcli_crm_sales',
            'truncate' => true,
        ],
        'ventes_2020' => [
            'class' => '\Wcli\Crm\Classes\Imports\SalesImport',
            'table' => 'wcli_crm_sales',
        ],
        'ventes_2021' => [
            'class' => '\Wcli\Crm\Classes\Imports\SalesImportDate',
            'table' => 'wcli_crm_sales',
        ],
        'clients' => [
            'class' => '\Wcli\Crm\Classes\Imports\ClientsImport',
            'table' => 'wcli_crm_clients',
            'truncate' => true,
        ],
        'gammes' => [
            'class' => '\Wcli\Crm\Classes\Imports\GammesImport',
            'table' => 'wcli_crm_gammes',
            'truncate' => true,
        ],
        'regions' => [
            'class' => '\Wcli\Crm\Classes\Imports\RegionsImport',
            'table' => 'wcli_crm_regions',
            'truncate' => true,
        ],

    ],
    'cloud' => [ //obligatoire si utilisation du cloud et du plugin lot
        'class' => 'Waka\Cloud\Classes\Cloud\Gd',
        'controller' => [
            'word' => [
                'show' => true,
                'class' => 'Waka\Worder\Models\Document',
                'constructor' => 'Waka\Worder\Classes\WordCreator2',
                'label' => 'Documents Word',
            ],
            'pdf' => [
                'show' => true,
                'class' => 'Waka\Pdfer\Models\WakaPdf',
                'constructor' => 'Waka\Pdfer\Classes\PdfCreator',
                'label' => 'Documents Pdf',
            ],
        ],
        'folderModel' => [
            'client' => [
                'model' => 'Wcli\Crm\Models\Client',
                'column_for_name' => 'name',
                'folder' => 'Clients',
            ],
            'region' => [
                'model' => 'Wcli\Crm\Models\Region',
                'folder' => 'Regions',
            ],
        ],
        'sync' => [
            'word' => [
                'label' => 'synchroniser doc word',
                'cloud_folder' => 'template_word',
                'app_folder' => 'word/templates/',
            ],

        ],
    ],
    'assets' => [ // obligatoire pour pdf et mailer
        'css' => [
            //si il  a du less penser à le mettre dans le registrer du plugin pour le combiner en css
            'pdf' => ['/wcli/wconfig/assets/css/simple_grid/pdf.css' => 'pdf de base'],
            'email' => ['/wcli/wconfig/assets/css/simple_grid/email.css' => 'email de base'],
        ],
    ],
    'colors' => [
        'primary' => '#181066',
        'secondary' => '#0FC9F5',
        'gd' => '#787978',
        'gl' => '#E0E0E0',
        'dark' => '#252525',
    ],
];
