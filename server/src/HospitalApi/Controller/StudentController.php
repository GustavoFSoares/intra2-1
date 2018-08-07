<?php
namespace HospitalApi\Controller;

use HospitalApi\Model\StudentModel;

class StudentController extends ControllerAbstract
{
    public function __construct() {
        parent::__construct(new StudentModel());
    }

    public function _mountEntity($values){
        $values = $this->getModel()->mount($values);

        return parent::_mountEntity($values);
    }

}