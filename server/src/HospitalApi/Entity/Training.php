<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Treinamento")
 * <b>Treinamento</b>
 */
class Training extends EntityAbstract
{

    /**
     * @var Integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String @Column(name="nome", type="string", length=255)
     */
    protected $name;

    
    /**
     * @var String @Column(name="local", type="string", length=255)
     */
    protected $place;
    
    /**
     * @var String @Column(name="tipo", type="string", length=255)
     */
    protected $type;

    /**
     * @var String @Column(name="tipoInstitucional", type="string", length=255, nullable=true)
     */
    protected $institutionalType;
    
    /**
     * @ManyToOne(targetEntity="User",cascade={"persist", "remove"})
     * @JoinColumn(name="id_usuarioInstrutor", nullable=false)
     */
    protected $instructor;
    
    /**
     * @var String @Column(name="hora_treinamento", type="string", length=255)
     */
    protected $timeTraining;

    /**
     * @var Integer @Column(name="carga_horaria", type="integer")
     */
    protected $workload;

    /**
     * @ManyToMany(targetEntity="User")
     * @JoinTable(name="Treinamento_Usuario",
     *      joinColumns={@JoinColumn(name="treinamento_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="usuario_id", referencedColumnName="id")}
     *      )
     */
    protected $users;

    public function __construct($id = '', $name = '') {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getPlace() {
        return $this->place;
    }
    public function setPlace($place) {
        $this->place = $place;

        return $this;
    }

    public function getType() {
        return $this->type;
    }
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    public function getInstitutionalType() {
        return $this->institutionalType;
    }
    public function setInstitutionalType($institutionalType) {
        $this->institutionalType = $institutionalType;

        return $this;
    }

    public function getInstructor() {
        return $this->instructor;
    }
    public function setInstructor($instructor) {
        $this->instructor = $instructor;

        return $this;
    }

    public function getTimeTraining() {
        return $this->timeTraining;
    }
    public function setTimeTraining($timeTraining) {
        $this->timeTraining = $timeTraining;

        return $this;
    }

    public function getWorkload() {
        return $this->workload;
    }
    public function setWorkload($workload) {
        $this->workload = $workload;

        return $this;
    }

    public function getUsers() {
        return $this->users;
    }
    public function addUser($user) {
        $this->users->add($user);

        return $this;
    }
    public function removeUser($user) {
        $this->users->removeElement($user);
        
        return $this;
    }
    public function setUsers($users) {
        $this->users = $users;

        return $this;
    }

}