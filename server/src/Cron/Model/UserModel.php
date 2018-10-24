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

    public function findByNameOrCode($name, $code) {
        $select = $this->em->createQueryBuilder();
        $select
            ->select('u')
            ->from('HospitalApi\Entity\User', 'u')
            ->where("LOWER(u.name) LIKE :name")
            ->setParameter('name', strtolower($name) )
            ->orWhere("u.code LIKE :code")
            ->setParameter('code', $code);

        try {
            return $select->getQuery()->getOneOrNullResult();
        } catch (\Exception $e) {
            $this->__construct();

            $delete = $this->em->createQueryBuilder();
            $delete
                ->delete('HospitalApi\Entity\User', 'u')
                ->where("u.name LIKE :name")
                ->setParameter('name', $name)
                ->orWhere("u.code LIKE :code")
                ->setParameter('code', $code);
            $delete->getQuery()->execute();
        }
    }

    public function makeId($name) {
        $name = \Helper\SlugHelper::removeSpaces($name);
        $id = "{$this->getFirstName($name)}.{$this->getLastName($name)}";
        return strtolower($id);
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
}