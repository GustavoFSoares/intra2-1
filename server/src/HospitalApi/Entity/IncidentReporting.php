<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Notificacao_Incidente")
 * <b>Notificação de Incidentes</b>
 */
class IncidentReporting extends EntityAbstract
{
    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Group")
     * @JoinColumn(name="local_falha_id", nullable=false)
     */
    protected $reportPlace;

    /**
     * @ManyToOne(targetEntity="Group")
     * @JoinColumn(name="local_relato_id", nullable=false)
     */
    protected $failedPlace;

    /**
     * @ManyToOne(targetEntity="Event")
     * @JoinColumn(name="evento_id", nullable=false)
     */
    protected $event;

    /**
     * @var Text
     *      @Column(name="ocorrido", type="text")
     */
    protected $description;

    /**
     * @var Text
     *      @Column(name="conduta", type="text")
     */
    protected $conduct;

    /**
     * @var Boolean
     *      @Column(name="retornar", type="boolean")
     */
    protected $mustReturn;

    /**
     * @var String
     *      @Column(name="relator_email", type="string", nullable=true)
     */
    protected $reporterEmail;
    
    /**
     * @var Boolean
     *      @Column(name="paciente_envolvido", type="boolean", nullable=true)
     */
    protected $patientInvolved;

    /**
     * @var Integer
     *      @Column(name="paciente_id", type="integer", nullable=true)
     */
    protected $patientId;
    
    /**
     * @var String
     *      @Column(name="paciente_nome", type="string", nullable=true)
     */
    protected $patientName;

    /**
     * @var DateTime
     *      @Column(name="data_registro", type="datetime")
     */
    protected $recordTime;

    /**
     * @var DateTime
     *      @Column(name="data_ocorrido", type="datetime")
     */
    protected $failedTime;

    /**
     * @ManyToMany(targetEntity="Group")
     * @JoinTable(name="Notificacao_Incidente_Lista_Transmissao",
    
     *      joinColumns={@JoinColumn(name="incidente_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="grupo_id", referencedColumnName="id")}
     *      )
     */
    protected $transmissionList;

    public function __construct() {
        $this->recordTime = new \DateTime();
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getPlace() {
        return [
            'reportPlace' => $this->reportPlace,
            'failedPlace' => $this->failedPlace,
        ];
    }
    public function setPlace($place) {
        $this->reportPlace = $place['reportPlace'];
        $this->failedPlace = $place['failedPlace'];

        return $this;
    }

    public function getReportPlace() {
        return $this->reportPlace;
    }
    public function setReportPlace($reportPlace) {
        $this->reportPlace = $reportPlace;

        return $this;
    }
   
    public function getFailedPlace() {
        return $this->failedPlace;
    }
    public function setFailedPlace($failedPlace) {
        $this->failedPlace = $failedPlace;

        return $this;
    }
   
    public function getEvent() {
        return $this->event;
    }
    public function setEvent($event) {
        $this->event = $event;

        return $this;
    }
   
    public function getDescription() {
        return $this->description;
    }
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    public function getConduct() {
        return $this->conduct;
    }
    public function setConduct($conduct) {
        $this->conduct = $conduct;

        return $this;
    }

    public function getMustReturn() {
        return $this->mustReturn;
    }
    public function setMustReturn($mustReturn) {
        $this->mustReturn = $mustReturn;

        return $this;
    }
   
    public function getReporterEmail() {
        return $this->reporterEmail;
    }
    public function setReporterEmail($reporterEmail) {
        $this->reporterEmail = $reporterEmail;

        return $this;
    }

    public function getPatient() {
        return [
            'id' => $this->patientId, 
            'name' => $this->patientName, 
            'involved' => $this->patientInvolved,
        ];
    }
    public function setPatient($patient) {
        $this->patientId = isset($patient['id']) ? $patient['id'] : null;
        $this->patientName = isset($patient['name']) ? $patient['name'] : null;
        $this->patientInvolved = $patient['involved'];

        return $this;
    }
    
    public function getPatientId() {
        return $this->patientId;
    }
    public function setPatientId($patientId) {
        $this->patientId = $patientId;

        return $this;
    }

    public function getPatientName() {
        return $this->patientName;
    }
    public function setPatientName($patientName) {
        $this->patientName = $patientName;

        return $this;
    }

    public function getPatientInvolved() {
        return $this->patientInvolved;
    }
    public function setPatientInvolved($patientInvolved) {
        $this->patientInvolved = $patientInvolved;

        return $this;
    }

    public function getRecordTime() {
        return $this->recordTime;
    }

    public function getFailedTime() {
        return $this->failedTime;
    }
    public function setFailedTime($failedTime) {
        $this->failedTime = $this->_formatDate($failedTime);

        return $this;
    }

    public function getTransmissionList() {
        return $this->transmissionList;
    }
    public function addGroupToTransmissionList($groups) {
        $this->transmissionList->add($groups);

        return $this;
    }
    public function removeGroupToTransmissionList($groups) {
        $this->transmissionList->removeElement($groups);
        
        return $this;
    }
    public function setTransmissionList($transmissionList) {
        $this->transmissionList = $transmissionList;

        return $this;
    }

}