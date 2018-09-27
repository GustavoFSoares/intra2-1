<?php

use HospitalApi\Entity\Module;
use HospitalApi\Model\ModuleModel;

echo "Atualizando Modulos\n";
$model = new ModuleModel();

    $modules = [
        [ 'name' => 'Alertas',                  'routeName' => 'alertas',                        'default' => false, 'icon' => 'exclamation' ],
        [ 'name' => 'Gerenciador de Módulos',   'routeName' => 'modulos',                        'default' => false, 'icon' => 'desktop' ],
        [ 'name' => 'Convênios',                'routeName' => 'convenios',                      'default' => false, 'icon' => 'handshake' ],
        [ 'name' => 'Usuários',                 'routeName' => 'usuarios/gerenciador',           'default' => true,  'icon' => 'users' ],
        [ 'name' => 'Treinamento',              'routeName' => 'hht',                            'default' => false, 'icon' => 'trophy' ],
        [ 'name' => 'Hora Homem Treinamento',   'routeName' => 'hht',                            'default' => false, 'icon' => 'medal' ],
        [ 'name' => 'Ramais',                   'routeName' => 'ramais',                         'default' => false, 'icon' => 'phone' ],
        [ 'name' => 'Colaboradores',            'routeName' => 'colaboradores',                  'default' => false, 'icon' => 'user-tie' ],
        [ 'name' => 'Notificação de Incidente', 'routeName' => 'notificacao-de-incidentes',      'default' => true,  'icon' => 'medal' ],
        [ 'name' => 'Administradores',          'routeName' => 'gerenciador-de-administradores', 'default' => false, 'icon' => 'crown' ],
    ];
    
    foreach ($modules as $module) {
        if(!$model->getRepository()->findByRouteName($module['routeName'])){
            $Module = new Module();
            $Module->setName($module['name'])
                ->setRouteName($module['routeName'])
                ->setDefault($module['default'])
                ->setIcon($module['icon']);
            $model->doInsert($Module);

            echo "      Modulo ".$module['name']." INSERTED\n";
        } else {
            echo "      Modulo ".$module['name']." ignored\n";
        }

    }
   