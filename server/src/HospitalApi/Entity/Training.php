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
     * @JoinColumn(name="instrutor_id", nullable=false)
     */
    protected $instructor;
    
    /**
     * @var DateTime @Column(name="inicio_hora_treinamento", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $beginTime;
    
    /**
     * @var DateTime @Column(name="final_hora_treinamento", type="datetime", nullable=true, options={"default":"CURRENT_TIMESTAMP"}, nullable=true)
     */
    protected $endTime;

    /**
     * @var Integer @Column(name="carga_horaria", type="integer")
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
        $this->type = '';
        $this->institutionalType = '';
        $this->instructor = new User();
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

}