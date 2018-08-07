<?php
namespace HospitalApi\Model;

use HospitalApi\Entity\User;

/**
* <b>StudentModel</b>
 */
class StudentModel extends SoftdeleteModel
{

    public $entity;

    public function __construct() {
        $this->entity = new User();

        ModelAbstract::__construct();
    }

    public function mount($values) {
        $values['student'] = true;
        $values['level'] = '1';

        $group = $this->em->getRepository('HospitalApi\Entity\Group')->find($values['group']['id']);
        $values['group'] = $group;

        return $values;
    }

    public function findAll() {
        $Students = $this->getRepository()->findBy(['student' => '1']);
        $students = [];

        if($Students) {
            foreach ($Students as $Student) {
                $group = $Student->getGroup()->toArray();
                $Student->setGroup($group);
                $students[] = $Student;
            }
        }
        return $students;
    }

    public function findById($id) {
        $Student = parent::findById($id);
        if($Student) {
            $group = $Student->getGroup()->toArray();
            $Student->setGroup($group);
        }
        return $Student;
    }

}