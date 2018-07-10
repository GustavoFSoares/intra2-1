<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Usuario")
 * <b>User</b>
 * Classe POJO responsável por manter os atributos de um User,
 * como também fazer as relações e mapeamento com banco de dados
 */
class User extends SoftdeleteAbstract
{

    /**
     * @var String @Id
     *     @Column(name="id", type="string")
     */
    protected $id;

    /**
     * @var string @Column(name="nome", type="string", length=255)
     */
    protected $name;

    /**
     * @var string @Column(name="nivel", type="string")
     */
    protected $level;
    
    /**
     * @var string @Column(name="ramal", type="string")
     */
    protected $ramal;

    /**
     * @ManyToOne(targetEntity="Group",cascade={"persist", "remove"})
     * @JoinColumn(name="grupo_id", referencedColumnName="id", nullable=true)
     */
    protected $group;

    /**
     * @var string @Column(name="cargo", type="string", options={"default":""})
     */
    protected $occupation;

    /**
     * @var string @Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $admin;

    public function __construct($id = '', $name = '', $level = '1', $ramal = '', $group = '', $occupation = '', $admin = false) {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->level = $level;
        $this->ramal = $ramal;
        $this->group = $group;
        $this->occupation = $occupation;
        $this->admin = 0;
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

    public function getLevel() {
        return $this->level;
    }
    public function setLevel($level) {
        $this->level = $level;

        return $this;
    }

    public function getRamal() {
        return $this->ramal;
    }
    public function setRamal($ramal) {
        $this->ramal = $ramal;

        return $this;
    }

    public function getGroup() {
        return $this->group;
    }
    public function setGroup($group) {
        $this->group = $group;
        
        return $this;
    }

    public function getOccupation() {
        return $this->occupation;
    }
    public function setOccupation($occupation) {
        $this->occupation = $occupation;

        return $this;
    }

    public function getAdmin() {
        return $this->admin;
    }
    public function setAdmin($admin) {
        $this->admin = $admin ? true : false;

        return $this;
    }


}