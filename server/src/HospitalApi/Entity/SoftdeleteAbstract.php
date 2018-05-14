<?php
namespace HospitalApi\Entity;

abstract class SoftdeleteAbstract extends EntityAbstract
{

    /**
     * @var Boolean
     *      @Column(type="boolean", options={"default" : false})
     */
    public $c_removed;

    public function __construct() {
        parent::__construct();
        $this->c_removed = false;
    }
}
    