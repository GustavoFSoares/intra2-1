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
     * @var string @Column(name="grupo", type="string")
     */
    protected $group;

    /**
     * @var string @Column(name="cargo", type="string")
     */
    protected $ocupation;

    /**
     * @var string @Column(type="boolean", default: false)
     */
    protected $admin;

    public function __contruct($name = '', $level = '', $group = '', $ocupation = '', $admin = false) {
        parent::__construct();
        $this->id = 0;
        $this->name = $name;
        $this->level = $level;
        $this->group = $group;
        $this->ocupation = $ocupation;
        $this->admin = $admin;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getname() {
        return $this->name;
    }
    public function setname($name) {
        $this->name = $name;

        return $this;
    }

    public function getlevel() {
        return $this->level;
    }
    public function setlevel($level) {
        $this->level = $level;

        return $this;
    }

    public function getGroup() {
        return $this->group;
    }
    public function setGroup($group) {
        $this->group = $group;

        return $this;
    }

    public function getOcupation() {
        return $this->ocupation;
    }
    public function setOcupation($ocupation) {
        $this->ocupation = $ocupation;

        return $this;
    }

    public function getAdmin() {
        return $this->admin;
    }
    public function setAdmin($admin) {
        $this->admin = $admin;

        return $this;
    }


}