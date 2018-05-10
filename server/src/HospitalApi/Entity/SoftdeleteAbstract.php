<?php
namespace HospitalApi\Entity;

abstract class SoftdeleteAbstract extends EntityAbstract
{

    /**
     * @var Boolean
     *      @Column(type="boolean", options={"default" : 0})
     */
    public $c_removed;
}
    