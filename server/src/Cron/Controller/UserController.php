<?php
namespace Cron\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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
    public function __construct() {
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
                                                    ->setOccupation($row['occupation'])
                                                    ->setActiveDirectory(true);
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
                                                    ->setOccupation($row['occupation'])
                                                    ->setActiveDirectory(true);

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

    public function integrateWithAdpFileAction() {
        \Helper\LoggerHelper::initLogFile('cron/user/adp', null, 'USER-ADP', 'Y/m/d His');
        echo \Helper\LoggerHelper::writeFile("Inicio: ".date('Y-m-d H:i:s')."\n");
        
        
        $adpPath = PATH.'/../files/adp/';
        
        $dir = scandir($adpPath);
        $file = end($dir);
        
        $excel = new \Helper\ExcelHelper( pathinfo($file, PATHINFO_EXTENSION) );
        $excel->loadFile($adpPath.$file);
        
        $GroupModel = new \Cron\Model\GroupModel();
        
        echo \Helper\LoggerHelper::writeFile("Arquivo analizado: $file\n");


        echo \Helper\LoggerHelper::writeFile("Verificando...\n");
        foreach ($excel->getRows() as $key => $data) {
            if($key == 0) {
                foreach ($data as $key => $label) {
                    $label = \Helper\SlugHelper::get($label);
                    $index[$label] = $key;
                }
                
                continue;
            }
            
            $data[ $index['nome'] ]        = \Helper\SlugHelper::removeSpaces($data[ $index['nome'] ]);
            $data[ $index['funcao-nome'] ] = \Helper\SlugHelper::removeSpaces($data[ $index['funcao-nome'] ]);
            
            $User = $this->model->findByNameOrCode($data[$index['nome']], $data[$index['matricula']]);
            if($User) {
                
                $User
                    ->setCode( $data[$index['matricula']] )
                    ->setName( $data[$index['nome']] )
                    ->setOccupation( $data[$index['funcao-nome']] )
                    ->setByAdp( true );
                
                $groupId = $GroupModel->getGroupByGroupMappingFiles( $data[$index['centro-de-resultado-nome']] );
                
                $group = $this->model->em->getRepository('HospitalApi\Entity\Group')->findOneByGroupId($groupId);
                
                if($group) {
                    $group = $this->model->em->getRepository('HospitalApi\Entity\Group')->find($group->getId());
                    $User->setGroup($group);
                } else {
                    
                    $this->saveIfGroupNotFound($data[$index['centro-de-resultado-nome']], $groupId, $User);
                    continue;
                    
                }

                $this->model->doUpdate($User);
                echo \Helper\LoggerHelper::writeFile("{$User->getId()} --> {$group->getName()} <-- Atualizado\n");
            } else {
                try {
   
                    $User = new User();
                    $User
                        ->setId( $this->model->makeId( $data[$index['nome']] ) )
                        ->setCode( $data[$index['matricula']] )
                        ->setName( $data[$index['nome']] )
                        ->setOccupation( $data[$index['funcao-nome']] )
                        ->setByAdp( true );
                    
                    $groupId = $GroupModel->getGroupByGroupMappingFiles( $data[$index['centro-de-resultado-nome']] );
                    
                    $group = $this->model->em->getRepository('HospitalApi\Entity\Group')->findOneByGroupId($groupId);
                    
                    if($group) {
                        $group = $this->model->em->getRepository('HospitalApi\Entity\Group')->find($group->getId());
                        $User->setGroup($group);
                    } else {
                        
                        $this->saveIfGroupNotFound($data[$index['centro-de-resultado-nome']], $groupId, $User);
                        continue;
                    }

                    $this->model->doInsert($User);
                    echo \Helper\LoggerHelper::writeFile("{$User->getId()} --> {$group->getName()} <-- Inserido\n");
                
                } catch (UniqueConstraintViolationException $e) {
                    $this->model = new \Cron\Model\UserModel();
                    $this->model->insertWithAnotherId($User);
                }
                
            }
        }
        
        echo \Helper\LoggerHelper::writeFile("--Atualizacao de Funcionarios via ADP-WEB finalizada--\n");
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

    public function saveIfGroupNotFound($adpGroup, $groupId, $User) {
        $groupId = $groupId ? $groupId : "undefined";
        $adpgroup = \Helper\SlugHelper::get($adpGroup);

        $notFoundGroup = "{$adpgroup}: \"{$groupId}\"\n";

        file_put_contents(PATH."/Cron/MappingGroup.yml", "    $notFoundGroup", FILE_APPEND);
        echo \Helper\LoggerHelper::writeFile("{$User->getId()} --> $groupId <-- Grupo não encontrado\n");
    }

}