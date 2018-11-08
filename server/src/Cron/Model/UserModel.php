<?php
namespace Cron\Model;

use HospitalApi\Model\ModelAbstract;
use HospitalApi\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class UserModel extends ModelAbstract
{

    public $entity;
    
    public function __construct(){
        $this->entity = new User();
        parent::__construct();
    }
    
    public function findByUserId($UserId){
        return $this->getRepository()->findOneByUserId($UserId);
    }

    public function getCentersFromFile($file) {
        $centers = [];
        
        foreach ($file->getRows() as $key => $data) {
            if($key == 0) {
                foreach ($data as $key => $label) {
                    $label = \Helper\SlugHelper::get($label);
                    $index[$label] = $key;
                }
                
                continue;
            }

            $center = \Helper\SlugHelper::get($data[$index['centro-de-resultado-nome']]);
            if(!in_array($center, $centers)) {
                $centers[] = $center;
            }
            
        }

        return $centers;
    }

    public function getRepository() {
        return $this->em->getRepository('HospitalApi\Entity\User');
    }

    public function findByNameOrCode($name, $code, $id = null) {
        $select = $this->em->createQueryBuilder();
        $select
            ->select('u')
            ->from('HospitalApi\Entity\User', 'u')
            ->where("LOWER(u.name) LIKE :name")
            ->setParameter('name', strtolower($name) );
        
        if( is_numeric($code) ) {
            $select
                ->orWhere("u.code LIKE :code")
                ->setParameter('code', $code);
        }

        if($id) {
            $select->setParameter('id', $id );
        } else {
            $select->setParameter('id', $this->makeId($name) );
        }
        $select->orWhere("u.id LIKE :id");

        try {
            return $select->getQuery()->getOneOrNullResult();
        } catch (\Exception $e) {
            $this->__construct();

            $delete = $this->em->createQueryBuilder();
            $delete
                ->delete('HospitalApi\Entity\User', 'u')
                ->where("u.name LIKE :name")
                ->setParameter('name', $name);
                
            if(is_numeric($code)) {
                $delete
                    ->orWhere("u.code LIKE :code")
                    ->setParameter('code', $code);
            }
            if($id) {
                $delete->setParameter('id', $id );
            } else {
                $delete->setParameter('id', $this->makeId($name) );
            }
            $delete->orWhere("u.id LIKE :id");
            $delete->getQuery()->execute();
        }
    }

    public function makeId($name) {
        $id = "{$this->getFirstName($name)}.{$this->getLastName($name)}";
        $id = strtolower($id);
        return utf8_decode($id);
    }

    public function getFirstName($name) {
        $re = '/^(\w+)/m';

        preg_match($re, $name, $matches, PREG_OFFSET_CAPTURE, 0);
        if(!$matches) {
            return "ERRONOME";
        }
        return $matches[0][0];
    }
    
    public function getLastName($name) {
        $re = '/(\w+)$/m';

        preg_match($re, $name, $matches, PREG_OFFSET_CAPTURE, 0);
        if(!$matches) {
            return "ERRONOME";
        }
        return $matches[0][0];

    }
    
    public function getMiddleName($name) {
        $re = '/(\s\w*\s)/m';

        preg_match($re, $name, $matches, PREG_OFFSET_CAPTURE, 0);
        if(!$matches) {
            return "ERRONOME";
        }
        return \Helper\SlugHelper::removeAllSpaces($matches[0][0]);
    }

    public function insertWithAnotherId(User $User) {
        try {
            $name = $User->getName();
            $id = "{$this->getFirstName($name)}.{$this->getMiddleName($name)}";

            $User->setId( strtolower($id) );

            $group = $this->em->getRepository('HospitalApi\Entity\Group')->find($User->getGroup()->getId());
            $User->setGroup($group);

            if(!$this->findByNameOrCode($User->getName(), $User->getCode())) {
                $this->doInsert($User);
            }

        } catch (UniqueConstraintViolationException $e) {
            echo \Helper\LoggerHelper::writeFile("ID: {$User->getId()} Nome: {$User->getName()} Grupo: {$User->getGroup()->getName()}--> NAO CADASTRADO <-- id duplicado\n");
            $this->__construct();
        }
    }
    
    public function getProblablyDuplicatedUsers($groupId) {
        $select = $this->em->createQueryBuilder();
        $select
            ->select( [
                'g.name as groupName',
                'u1.id AS UserId1', 'u1.name AS UserName1', 'u1.code AS UserCode1',
                'u2.id AS UserId2', 'u2.name as UserName2', 'u2.code as UserCode2',
            ])
            ->from('HospitalApi\Entity\User', 'u1')
            ->innerJoin('HospitalApi\Entity\User', 'u2', 'WITH', 'u1.id <> u2.id AND 
                substring(u1.name, 1, 3) LIKE substring(u2.name, 1, 3) ')
            ->innerJoin('HospitalApi\Entity\Group', 'g', 'WITH', 'g = u1.group AND g = u2.group')
            ->where("g.groupId LIKE :groupId")
            ->setParameter('groupId', $groupId)
            ->andWhere('u1.activeDirectory = 1')
            ->andWhere('u2.byAdp = 1')
            ->andWhere('length(u1.id) > 2')
            ->andWhere('length(u1.id) > 2');
        return $select->getQuery()->getResult(); 
    }

    public function isAvailableCode($code1, $code2) {
        if( is_numeric($code1) && is_numeric($code2) ) {
            if( strlen($code1) && strlen($code2) ) {
                return true;
            }
        }
        
        return false;
    }

    public function getMatcingsByName($fullname1, $fullname2) {
        $matching = 0;
        foreach ($fullname1 as $name1) {
            foreach ($fullname2 as $name2) {
        
                if(strlen($name1) >= 4 && strlen($name2) >= 4) {
                    if($name1 == $name2) {
                        $matching++;
                    }
                }

            }
        }

        return $matching;
    }
}