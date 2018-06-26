<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Grupo")
 */
class Group extends SoftdeleteAbstract
{

    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     *      @Column(name="grupo_id", type="string", length=255)
     */
    protected $groupId;

        /**
     * @var String
     *      @Column(name="nome", type="string", length=255)
     */
    protected $name;

    /**
     * @var String
     *      @Column(name="empresa", type="string", length=255)
     */
    protected $enterprise;

    public function __construct($id = 0, $groupId = '', $name = '', $enterprise = '') {
        parent::__construct();
        $this->id = $id;
        $this->groupId = $groupId;
        $this->name = $name;
        $this->enterprise = $enterprise;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }
    
    public function getGroupId() {
        return $this->groupId;
    }
    public function setGroupId($groupId) {
        $this->groupId = $groupId;

        return $this;
    }
   
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;

        return $this;
    }
    
    public function getEnterprise() {
        return $this->enterprise;
    }
    public function setEnterprise($enterprise) {
        $this->enterprise = $enterprise;

        return $this;
    }
}