<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Grupo")
 */
class Groups extends SoftdeleteAbstract
{

    /**
     * @var integer @Id
     *     @Column(name="id", type="string")
     */
    protected $id;

    public function __construct($id = 0)
    {
        parent::__construct();
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }
}