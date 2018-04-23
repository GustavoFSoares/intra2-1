<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Eventos_Adversos")
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
     *      @Column(name="paciente_envolvido", type="boolean")
     */
    protected $patientEnvolved;

    /**
     * @var Integer
     *      @Column(name="cd_atendimento", type="integer")
     */
    protected $patientId;

    /**
     * @OneToOne(targetEntity="Enterprise",cascade={"persist"})
     * @JoinColumn(name="id_empresa", referencedColumnName="id")
     */
    protected $Empresa;

    /**
     * @OneToOne(targetEntity="Sector",cascade={"persist"})
     * @JoinColumn(name="id_setor", referencedColumnName="id")
     */
    protected $Setor;

    /**
     * @OneToOne(targetEntity="Events",cascade={"persist"})
     * @JoinColumn(name="id_evento", referencedColumnName="id")
     */
    protected $Event;

    /**
     * @var DateTime
     *      @Column(type="string")
     */
    protected $time;

    public function __construct($event = "", $setor = "", $complement = [ ], $personId = 0, $patientName = [ ]) {
        $this->event = $event;
        $this->setor = $setor;
    
        $this->description = $complement['description'];
        $this->conduct = $complement['conduct'];

        $this->personId = $personId;

        if($patient['envolved']){
            $this->patientEnvolved = true;
            $this->patientId = $patient['id'];
        }

        $this->time = date('Y-m-d H:i');
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getUnit() {
        return $this->unit;
    }
    public function setUnit($unit) {
        $this->unit = $unit;

        return $this;
    }

    public function getSetor() {
        return $this->setor;
    }
    public function setSetor($setor) {
        $this->setor = $setor;

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

    public function getPerson() {
        return $this->person;
    }
    public function setPerson($person) {
        $this->person = $person;

        return $this;
    }

    public function getPatientEnvolved() {
        return $this->patientEnvolved;
    }
    public function setPatientEnvolved($patientEnvolved) {
        $this->patientEnvolved = $patientEnvolved;

        return $this;
    }

    public function getPatientId() {
        return $this->patientId;
    }
    public function setPatientId($patientId) {
        $this->patientId = $patientId;

        return $this;
    }

    public function getTime() {
        return $this->time;
    }

}