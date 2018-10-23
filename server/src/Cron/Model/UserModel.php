<?php
namespace Cron\Model;

use HospitalApi\Model\ModelAbstract;
use HospitalApi\Entity\User;
use Symfony\Component\Yaml\Yaml;

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
            ->where("u.name LIKE :name")
            ->setParameter('name', $name)
            ->orWhere("u.code LIKE :code")
            ->setParameter('code', $code);
        return $select->getQuery()->getOneOrNullResult();
    }

    public function getGroupByGroupMappingFiles($adpCenter) {
        $enterprise = $this->discoverEnterprise($adpCenter);
        $adpCenter = \Helper\SlugHelper::get($adpCenter);

        $file = file_get_contents(PATH.'/Cron/MappingGroup.yml');
        $yaml = Yaml::parse($file);
        
        if(in_array($adpCenter, $yaml[$enterprise])) {
            return $yaml[$enterprise][$adpCenter];
        }
    }

    public function discoverEnterprise($adpCenter) {
        $re = '/(h[p,u]\w{0,2})/mi';
        preg_match_all($re, $adpCenter, $matches, PREG_SET_ORDER, 0);
        
        return $matches[0][1] ? $matches[0][1] : '';
    }

}