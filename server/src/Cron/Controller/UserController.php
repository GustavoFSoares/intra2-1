<?php
namespace Cron\Controller;

use HospitalApi\BasicApplicationAbstract;
use HospitalApi\Controller\ActiveDirectoryController;
use HospitalApi\Entity\User;
use Cocur\Slugify\Slugify;
/**
 * <b>ActiveDirectoryController</b>
 */
class UserController extends BasicApplicationAbstract
{

    public $model;
    public function __construct(){
        $this->model = new \Cron\Model\UserModel();
    }

    public function update() {
        $AD = new ActiveDirectoryController();
        $alph = ['a', 'b', 'c', 'd', 'e', 'f',
        		 'g', 'h', 'i', 'j', 'k', 'l',
        		 'm', 'n', 'o', 'p', 'q', 'r',
        		 's', 't', 'u', 'v', 'w', 'x',
                 'y', 'z', '.'];
        
        \Helper\LoggerHelper::initLogFile('cron/user', null, 'USER', 'Y/m/d His');
        echo \Helper\LoggerHelper::writeFile("Verificando...\n");
        foreach ($alph as $letter) {
            foreach ($alph as $secondLetter) {
                foreach ($alph as $thirdLetter) {
                    foreach ($alph as $fourthLetter) {
                        
                        $users = $AD->getUsers($letter.$secondLetter.$thirdLetter.$fourthLetter);
                        if($users['count']){
                            
                            foreach ($users as $user) {
                                if(is_array($user)) {

                                    $id = $user['samaccountname']['0'];
                                    $active = $AD->isActive($id);
                                    $User = $this->model->getRepository()->find($id);
                                    
                                    if($active) {
                                        /* Ativo e COM usuário cadastrado */
                                        if($User) {
                                            $row = [
                                                'name' => $user['displayname'][0],
                                                'group' => $AD->getGroupArray(isset($user['department']) ? $user['department'][0] : '' ),
                                                'occupation' => $user['description'][0]?$user['description'][0]:'',
                                                'code' => $user['physicaldeliveryofficename'][0]?$user['physicaldeliveryofficename'][0]:'sem-matricula',
                                            ];
                                            
                                            $group = $this->getRepositoryGroupById($row['group']['name']);
                                            if(!$group){
                                                echo \Helper\LoggerHelper::writeFile("$id --> {$row['group']['name']} <-- Ativo - Grupo nao encontrado\n");
                                            } else {

                                                $User
                                                    ->setCode($row['code'])
                                                    ->setName($row['name'])
                                                    ->setGroup($group)
                                                    ->setOccupation($row['occupation']);
                                                $this->model->doUpdate($User);
                                                echo \Helper\LoggerHelper::writeFile("$id --> {$row['group']['name']} <-- Ativo - Atualizado\n");
                                            }

                                        /* Ativo e SEM usuário  cadastrado */
                                        } else {
                                            $row = [
                                                'id' => $user['samaccountname'][0],
                                                'name' => $user['displayname'][0],
                                                'group' => $AD->getGroupArray(isset($user['department']) ? $user['department'][0] : '' ),
                                                'occupation' => $user['description'][0]?$user['description'][0]:'',
                                                'code' => $user['physicaldeliveryofficename'][0]?$user['physicaldeliveryofficename'][0]:'sem-matricula',
                                            ];
                                            $group = $this->getRepositoryGroupById($row['group']['name']);

                                            if(!$group){
                                                echo \Helper\LoggerHelper::writeFile("$id --> {$row['group']['name']} <-- Ativo - Grupo nao encontrado\n");
                                            } else {

                                                $User = new User();
                                                $User
                                                    ->setId($row['id'])
                                                    ->setCode($row['code'])
                                                    ->setName($row['name'])
                                                    ->setGroup($group)
                                                    ->setOccupation($row['occupation']);
                                                $this->model->doInsert($User);
                                                echo \Helper\LoggerHelper::writeFile("$id --> {$row['group']['name']} <-- Ativo - Adicionado\n");
                                            }

                                        }
                                    } else {

                                        /* Desativado e COM usuário cadastrado */
                                        if($User) {
                                            $User
                                                ->setC_removed(true);
                                            $this->model->doUpdate($User);
                                            echo \Helper\LoggerHelper::writeFile("$id --> {$row['group']['name']} <-- Desativado - Usuário Inativado\n");
                                        
                                        /* Desativado e SEM usuário cadastrado */
                                        } else {
                                            echo \Helper\LoggerHelper::writeFile("$id --> {$row['group']['name']} <-- Desativado - Ignorado\n");
                                        }
                                    }


                                }
                                
                            }

                        }
                        

                    }
                }
            }
        }
        echo \Helper\LoggerHelper::writeFile("--Atualizacao de Funcionarios finalizada--\n");
        echo \Helper\LoggerHelper::writeFile("Fim: ".date('Y-m-d H:i:s')."\n");
        
    }

    public function getModel() {
        return new \HospitalApi\Model\UserModel();
    }

    public function getRepositoryGroupById($id) {
        $groupRepository = $this->model->em->getRepository('HospitalApi\Entity\Group');
        $group = $groupRepository->findOneByGroupId(\Helper\SlugHelper::get($id));
        
        return $group;
    }

}