<?php
namespace HospitalApi\Entity;
use DateTime;

/**
 * @Entity
 * @Table(name="Ouvidoria_Mensagens")
 * <b>OmbudsmanMessages</b>
 */
class OmbudsmanMessages extends EntityAbstract
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
     * @var Ombudsman
     *      @ManytoOne(targetEntity="Ombudsman")
     *      @JoinColumn(name="ouvidoria_id", onDelete="CASCADE")
     */
    protected $ombudsman;

    public function __construct() {
        parent::__construct();
        $this->id = 0;
        $this->user = '';
        $this->message = '';
        $this->ombudsman = '';
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
        $this->user = $this->getRepositoryOf('User', $user);

        return $this;
    }

    public function getMessage() {
        return $this->message;
    }
    public function setMessage($message) {
        $this->message = $message;

        return $this;
    }
    
    public function getOmbudsman() {
        return $this->ombudsman;
    }
    public function setOmbudsman($ombudsman) {
        $this->ombudsman = $this->getRepositoryOf('Ombudsman', $ombudsman);

        return $this;
    }

    public function getTime(){
        return $this->time;
    }
}