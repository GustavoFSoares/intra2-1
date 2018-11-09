<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Rotina")
 * <b>Rotine</b>
 */
class Rotine extends SoftdeleteAbstract
{

    /**
     * @var Integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String @Column(name="nome", type="string")
     */
    protected $name;

    /**
     * @var String @Column(name="origem", type="string")
     */
    protected $from;

    /**
     * @var String @Column(name="alvo", type="string")
     */
    protected $target;

    /**
     * @var Datetime
     *      @Column(name="horario_inicio", type="datetime", nullable=true, options={"default":"CURRENT_TIMESTAMP"})
     */
    public $timeBegin;
    
    /**
     * @var Datetime
     *      @Column(name="horario_fim", type="datetime", nullable=true, options={"default":"CURRENT_TIMESTAMP"})
     */
    public $timeEnd;



    public function __construct($name = '', $from = '', $target = '') {
        parent::__construct();
        $this->id = '';
        $this->name = $name;
        $this->from = $from;
        $this->target = $target;
        $this->timeBegin = new \DateTime();
        $this->timeEnd = null;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id){
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

    public function getFrom() {
        return $this->from;
    }
    public function setFrom($from) {
        $this->from = $from;

        return $this;
    }

    public function getTarget() {
        return $this->target;
    }
    public function setTarget($target) {
        $this->target = $target;

        return $this;
    }

    public function getTimeBegin() {
        return $this->timeBegin;
    }
    public function setTimeBegin($timeBegin) {
        $this->timeBegin = $timeBegin;

        return $this;
    }

    public function getTimeEnd() {
        return $this->timeEnd;
    }
    public function setTimeEnd($timeEnd) {
        $this->timeEnd = $timeEnd;

        return $this;
    }

}