<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Notificacoes_Notificacao_Incidente")
 * <b>NotificationsIncidentReporting</b>
 */
class NotificationsIncidentReporting extends EntityAbstract
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
     * @var Integer
     *      @Column(name="quantidade", type="integer", options={ "default":"1" })
     */
    protected $count;
    
    /**
     * @var IncidentReporting
     *      @ManytoOne(targetEntity="IncidentReporting")
     *      @JoinColumn(name="incidente_id")
     */
    protected $incident;

    public function __construct() {
        parent::__construct();
        $this->id = 0;
        $this->count = 1;
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

    public function getCount() {
        return $this->count;
    }
    public function setCount($count) {
        $this->count = $count;
        
        return $this;
    }
    public function plusOne() {
        $this->count = $this->getCount()+1;
    
        return $this;
    }

    public function getIncident() {
        return $this->incident;
    }
    public function setIncident($incident) {
        $this->incident = $incident;

        return $this;
    }

}