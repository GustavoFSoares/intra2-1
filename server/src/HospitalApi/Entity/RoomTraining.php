<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Sala_Treinamento")
 * <b>RoomTraining</b>
 * Classe contendo o objeto dos Ramais cadastrados
 */
class RoomTraining extends SoftdeleteAbstract
{

    /**
     * @var integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string @Column(name="nome", type="string", length=255)
     */
    protected $name;

    /**
     * @var string @Column(name="andar", type="string", length=255)
     */
    protected $floor;

    /**
     * @ManyToOne(targetEntity="Group")
     * @JoinColumn(name="grupo_id", onDelete="CASCADE")
     */
    protected $group;
    
    public function __construct($id = 0, $name = "", $floor = "", $group = "") {
        parent::__construct();
        $this->id = $id;
        $this->number = $name;
        $this->core = $floor;
        $this->group = $group;
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