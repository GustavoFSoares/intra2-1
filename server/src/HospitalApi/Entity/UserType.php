<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Usuario_Tipo")
 * <b>UserTypes</b>
 */
class UserType extends SoftdeleteAbstract
{
    /**
     * @var String @Id
     *      @Column(name="id", type="string")
     */
    protected $id;

    /**
     * @var String
     *      @Column(name="nome", type="string", length=255)
     */
    protected $name;

    public function __construct($id = null, $name = "") {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

}