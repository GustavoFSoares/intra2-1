<?php
namespace Cron\Model;

use HospitalApi\Model\ModelAbstract;
use HospitalApi\Entity\Group;
use Symfony\Component\Yaml\Yaml;

class GroupModel extends ModelAbstract
{

    public $entity;
    
    public function __construct(){
        $this->entity = new Group();
        parent::__construct();
    }
    
    public function findByGroupId($groupId){
        return $this->getRepository()->findOneByGroupId($groupId);
    }

    public function findGroupsId() {
        $query = $this->em->createQueryBuilder();
        $query->select('g.groupId')
            ->from('HospitalApi\Entity\Group', 'g')
            ->where('g.c_removed = 0');
        $values = $query->getQuery()->getResult();

        $data = [];
        foreach ($values as $key => $value) {
            $data[] = $value['groupId'];
        }

        return $data;
    }

    public function getGroupByGroupMappingFiles($adpCenter) {
        $group = $this->getGroupArray($adpCenter);
        
        $adpCenter = \Helper\SlugHelper::get($adpCenter);
        if(!$adpCenter) {
            return false;
        }

        $file = file_get_contents(PATH.'/Cron/MappingGroup.yml');
        $yaml = Yaml::parse($file);
        
        if(array_key_exists($adpCenter, $yaml[ strtoupper($group['enterprise']) ])) {
            return $yaml[ $group['enterprise'] ][$adpCenter];
        }
    }

    public function getLastWord($word) {
        $re = '/\s(\w+)$/m';
        preg_match_all($re, $word, $matches, PREG_SET_ORDER, 1);
        return $matches[0][1] ? $matches[0][1] : '';
    }

    private function _isHospital($word) {
        $re = '/(h[p,u]\w{0,2})/mi';
        preg_match_all($re, $word, $matches, PREG_SET_ORDER, 0);
        return $matches ? $matches[0][1] : '';
    }

    private function _isCaps($word){
        $re = '/caps/mi';
        preg_match_all($re, $word, $matches, PREG_SET_ORDER, 0);
        return $matches ? $matches[0][0] : '';
    }
    
    private function _isUpa($word){
        $word = \Helper\SlugHelper::removeSpaces($word);
        $re = '/upa\s/mi';
        preg_match_all($re, $word, $matches, PREG_SET_ORDER, 0);
        return $matches ? $matches[0][0] : '';
    }

    public function getGroupArray($nameGroup) {
        if(       $enterprise = $this->_isUpa($nameGroup)) {
        } else if($enterprise = $this->_isCaps($nameGroup)) {
        } else if($enterprise = $this->_isHospital($nameGroup)) {
        } else {
            $enterprise = $nameGroup;
        }

        return ['name' => $nameGroup, 'enterprise' => \Helper\SlugHelper::removeAllSpaces($enterprise)];
    }

}