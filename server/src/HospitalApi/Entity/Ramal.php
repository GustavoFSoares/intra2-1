<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Ramal")
 * <b>Ramal</b>
 * Classe contendo o objeto dos Ramais cadastrados
 */
class Ramal extends SoftdeleteAbstract
{

    /**
     * @var integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string @Column(name="nu_ramal", type="integer", length=255)
     */
    protected $number;

    /**
     * @var string @Column(name="ds_nucleo", type="string", length=255)
     */
    protected $core;

    /**
     * @var string @Column(name="andar", type="string", length=255)
     */
    protected $floor;

    /**
     * @ManyToOne(targetEntity="Group",cascade={"persist", "remove"})
     * @JoinColumn(name="grupo_id", onDelete="CASCADE")
     */
    protected $group;
    
    public function __construct($id = 0, $number = "", $core = "", $group = "") {
        parent::__construct();
        $this->id = $id;
        $this->number = $number;
        $this->core = $core;
        $this->group = $group;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getNumber() {
        return $this->number;
    }
    public function setNumber($number) {
        $this->number = $number;

        return $this;
    }

    public function getCore() {
        return $this->core;
    }
    public function setCore($core) {
        $this->core = $core;

        return $this;
    }
    
    public function getFloor() {
        return $this->floor;
    }
    public function setFloor($floor) {
        $this->floor = $floor;

        return $this;
    }

    public function getGroup() {
        return $this->group;
    }
    public function setGroup($group) {
        $this->group = $group;

        return $this;
    }

}