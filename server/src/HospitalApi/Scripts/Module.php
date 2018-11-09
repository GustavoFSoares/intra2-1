<?php

use HospitalApi\Entity\Module;
use HospitalApi\Model\ModuleModel;

echo "Atualizando Modulos\n";
$model = new ModuleModel();

    $modules = [
        [ 'name' => 'Tecnologia da Informação', 'routeName' => 'timanager',                      'default' => false, 'icon' => 'desktop'       , 'parent_route_name' => null,        ],
        [ 'name' => 'Alertas',                  'routeName' => 'alertas',                        'default' => false, 'icon' => 'exclamation'   , 'parent_route_name' => 'timanager', ],
        [ 'name' => 'Rotinas',                  'routeName' => 'rotinas',                        'default' => false, 'icon' => 'hourglass-half', 'parent_route_name' => 'timanager', ],
        [ 'name' => 'Usuários Duplicados',      'routeName' => 'usuarios-duplicados',            'default' => false, 'icon' => 'user-friends'  , 'parent_route_name' => 'timanager', ],
        [ 'name' => 'Módulos',                  'routeName' => 'modulos',                        'default' => false, 'icon' => 'box'           , 'parent_route_name' => 'timanager', ],
        [ 'name' => 'Convênios',                'routeName' => 'convenios',                      'default' => false, 'icon' => 'handshake'     , 'parent_route_name' => null,        ],
        [ 'name' => 'Usuários',                 'routeName' => 'usuarios/gerenciador',           'default' => true,  'icon' => 'users'         , 'parent_route_name' => null,        ],
        [ 'name' => 'Ensino e Pesquisa',        'routeName' => 'training',                       'default' => false, 'icon' => 'trophy'        , 'parent_route_name' => null,        ],
        [ 'name' => 'Treinamentos',             'routeName' => 'hht',                            'default' => false, 'icon' => 'medal'         , 'parent_route_name' => 'training',  ],
        [ 'name' => 'Ramais',                   'routeName' => 'ramais',                         'default' => false, 'icon' => 'phone'         , 'parent_route_name' => null,        ],
        [ 'name' => 'Colaboradores',            'routeName' => 'colaboradores',                  'default' => false, 'icon' => 'user-tie'      , 'parent_route_name' => 'training',  ],
        [ 'name' => 'Notificação de Incidente', 'routeName' => 'notificacao-de-incidentes',      'default' => true,  'icon' => 'medal'         , 'parent_route_name' => null,        ],
        [ 'name' => 'Administradores',          'routeName' => 'gerenciador-de-administradores', 'default' => false, 'icon' => 'crown'         , 'parent_route_name' => null,        ],
        [ 'name' => 'Salas',                    'routeName' => 'sala-treinamento',               'default' => false, 'icon' => 'building'      , 'parent_route_name' => 'training',  ],
    ];
    
    foreach ($modules as $module) {
        $Module = $model->getRepository()->findOneByRouteName($module['routeName']);
        if(!$Module){
            $Module = new Module();
            $Module->setName($module['name'])
                ->setRouteName($module['routeName'])
                ->setDefault($module['default'])
                ->setIcon($module['icon']);
            if($module['parent_route_name']) {
                $parentModule = $model->getRepository()->findOneByRouteName($module['parent_route_name']);
                $Module->setParent($parentModule);
            }
            $model->doInsert($Module);

            echo "      Modulo ".$module['name']." INSERTED\n";
        } else {
            $Module->setName($module['name'])
                ->setRouteName($module['routeName'])
                ->setDefault($module['default'])
                ->setIcon($module['icon']);
            if($module['parent_route_name']) {
                $parentModule = $model->getRepository()->findOneByRouteName($module['parent_route_name']);
                $Module->setParent($parentModule);
            }
            $model->doUpdate($Module);
            echo "      Modulo ".$module['name']." ATUALIZADO\n";
        }

    }
   