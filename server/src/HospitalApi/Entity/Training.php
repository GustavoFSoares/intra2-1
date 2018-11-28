<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 * @Table(name="Treinamento")
 * <b>Treinamento</b>
 */
class Training extends SoftdeleteAbstract
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
    protected $enterprise;
    
    /**
     * @ManyToOne(targetEntity="RoomTraining")
     * @JoinColumn(name="sala_id", referencedColumnName="id", nullable=true)
     */
    protected $room;
    
    /**
     * @var String @Column(name="tipo", type="string", length=255)
     */
    protected $type;

    /**
     * @var String @Column(name="tipo_institucional", type="string", length=255, nullable=true)
     */
    protected $institutionalType;
    
    /**
     * @ManyToMany(targetEntity="User")
     * @JoinTable(name="Treinamento_Instrutor",
     *      joinColumns={@JoinColumn(name="treinamento_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="instrutor_id", referencedColumnName="id")}
     *      )
     */
    protected $instructors;
    
    /**
     * @var DateTime @Column(name="inicio_hora_treinamento", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $beginTime;
    
    /**
     * @var DateTime @Column(name="final_hora_treinamento", type="datetime", nullable=true, options={"default":"CURRENT_TIMESTAMP"}, nullable=true)
     */
    protected $endTime;

    /**
     * @var String @Column(name="carga_horaria", type="float")
     */
    protected $workload;

    /**
     * @var Boolean @Column(name="realizado", type="boolean")
     */
    protected $done;

    public function __construct() {
        parent::__construct();
        $this->id = '';
        $this->name = '';
        $this->place = '';
        $this->room = '';
        $this->type = '';
        $this->institutionalType = '';
        $this->instructors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->beginTime = new \DateTime();
        $this->endTime = null;
        $this->workload = '';
        $this->done = false;
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

    public function getEnterprise() {
        return $this->enterprise;
    }
    public function setEnterprise($enterprise) {
        $this->enterprise = $enterprise;

        return $this;
    }
    
    public function getRoom() {
        return $this->room;
    }
    public function setRoom($room) {
        if( is_integer($room) ) {
            $this->room = $this->getEntityManager()->getRepository('HospitalApi\Entity\RoomTraining')->find($room);
        } else {
            $this->room = $room;
        }

        return $this;
    }

    public function getPlace() {
        return $this->place;
    }
    public function setPlace($place) {
        $this->setEnterprise($place['enterprise']);
        $this->setRoom($place['room']);

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

    public function getInstructors() {
        return $this->instructors;
    }
    public function addInstructor($instructor) {
        $this->instructors->add($instructor);

        return $this;
    }
    public function removeInstructor($instructor) {
        $this->instructors->removeElement($instructor);
        
        return $this;
    }
    public function setInstructors($instructors) {
        $this->instructors = $instructors;

        return $this;
    }

    public function getBeginTime() {
        return $this->beginTime;
    }
    public function setBeginTime($beginTime) {
        $this->beginTime = $this->_formatDate($beginTime);

        return $this;
    }
    
    public function getEndTime() {
        return $this->endTime;
    }
    public function setEndTime($endtime) {
        $this->endTime = $this->_formatDate($endtime);

        return $this;
    }

    public function getWorkload() {
        return $this->workload;
    }
    public function setWorkload($workload) {
        $this->workload = $workload;

        return $this;
    }

    public function getDone() {
        return $this->done;
    }
    public function setDone($done) {
        $this->done = $done;

        return $this;
    }

    // public function _formatDate($date) {
    //     $date = date("Y-m-d H:i:s", $date);
    //     $date = \DateTime::createFromFormat("Y-m-d H:i:s", $date);

    //     return $date;
    // }

}