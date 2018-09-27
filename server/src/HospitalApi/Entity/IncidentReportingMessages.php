<?php
namespace HospitalApi\Entity;
use DateTime;

/**
 * @Entity
 * @Table(name="Notificacao_Incidente_Mensagens")
 * <b>IncidentReportingMessages</b>
 * Classe POJO que contém os atributos de um Chefe de Setor,
 * sendo atributos obrigatórios Nome e E-mail
 */
class IncidentReportingMessages extends EntityAbstract
{
    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     *      @ManytoOne(targetEntity="User")
     *      @JoinColumn(name="usuario_id")
     */
    protected $user;

    /**
     * @var String
     *      @Column(name="mensagem", type="text")
     */
    protected $message;
    
    /**
     * @var String
     *      @Column(name="lido", type="boolean", options={"default":true})
     */
    protected $read;
    
    /**
     * @var String
     *      @Column(name="horario", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $time;

    /**
     * @var IncidentReporting
     *      @ManytoOne(targetEntity="IncidentReporting")
     *      @JoinColumn(name="incidente_id")
     */
    protected $incident;

    public function __construct() {
        parent::__construct();
        $this->id = 0;
        $this->user = '';
        $this->message = '';
        $this->incident = '';
        $this->time = new DateTime();
        $this->read = true;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getUser() {
        return $this->user;
    }
    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    public function getMessage() {
        return $this->message;
    }
    public function setMessage($message) {
        $this->message = $message;

        return $this;
    }
    
    public function getIncident() {
        return $this->incident;
    }
    public function setIncident($incident) {
        $this->incident = $incident;

        return $this;
    }

    public function getTime(){
        return $this->time;
    }
}