<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Eventos_Adversos")
 * @Table(name="Eventos_Adversos",uniqueConstraints={@UniqueConstraint(name="search_idx", columns={"id"})})
 * <b>Eventos Adversos</b>
 * Classe POJO responsavel pela gerência dos Eventos Adversos(AdverseEvents)
 * contendo as Descrições (Conduta e Descrição), Identificador do Paciente e
 * os Objetos de tipo de Evento, Chefe de Setor e Empresa
 */
class AdverseEvents extends EntityAbstract
{
    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Enterprise",cascade={"persist", "remove"})
     * @JoinColumn(name="id_empresa")
     */
    protected $Enterprise;

    /**
     * @ManyToOne(targetEntity="Sector",cascade={"persist", "remove"})
     * @JoinColumn(name="id_setor")
     */
    protected $Sector;

    /**
     * @ManyToOne(targetEntity="Event",cascade={"persist", "remove"})
     * @JoinColumn(name="id_evento", nullable=false)
     */
    protected $Event;

    /**
     * @var Text
     *      @Column(name="ds_ocorrido", type="text")
     */
    protected $description;

    /**
     * @var Text
     *      @Column(name="ds_conduta", type="text")
     */
    protected $conduct;

    /**
     * @var Boolean
     *      @Column(name="retornar", type="boolean")
     */
    protected $mustReturn;

    /**
     * @var Boolean
     *      @Column(name="paciente_envolvido", type="boolean", nullable=true)
     */
    protected $patientInvolved;

    /**
     * @var Integer
     *      @Column(name="cd_atendimento", type="integer", nullable=true)
     */
    protected $patientId;

    /**
     * @var DateTime
     *      @Column(type="string")
     */
    protected $time;

    public function __construct($enterprise, $sector, $event) {
        $this->Enterprise = $enterprise;
        $this->Sector = $sector;
        $this->Event = $event;
    
        $this->time = date('Y-m-d H:i');
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getEnterprise() {
        return $this->enterprise;
    }

    public function getSector() {
        return $this->Sector;
    }

    public function getEvent() {
        return $this->Event;
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

    public function getComplement() {
        return [
            'description' => $this->description,
            'conduct' => $this->conduct
        ];
    }
    public function setComplement($complement) {
        $this->description = $complement['description'];
        $this->conduct = $complement['conduct'];

        return $this;
    }

    public function isMustReturn() {
        return $this->patientInvolved;
    }
    public function mustReturn($return) {
        $this->mustReturn = $return;

        return $this;
    }

    public function getPatientInvolved() {
        return $this->patientInvolved;
    }
    public function setPatientInvolved($patientInvolved) {
        $this->patientInvolved = $patientInvolved;

        return $this;
    }

    public function getPatientId() {
        return $this->patientId;
    }
    public function setPatientId($patientId) {
        $this->patientId = $patientId;

        return $this;
    }

    public function getPatient() {
        return [
            'involved' => $this->patientInvolved,
            'number' => $this->patientId 
        ];
    }
    public function setPatient($patient) {
        $this->patientId = $patient['number'];
        $this->patientInvolved = $patient['involved'];

        return $this;
    }

    public function getTime() {
        return $this->time;
    }

}