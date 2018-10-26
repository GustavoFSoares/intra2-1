<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Usuario_Duplicado")
 * <b>DuplicatedUsers</b>
 */
class DuplicatedUsers extends EntityAbstract
{

    /**
     * @var Integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @JoinColumn(name="user_id1", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user1;
   
    /**
     * @ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @JoinColumn(name="user_id2", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user2;

    /**
     * @var Datetime
     *      @Column(name="horario", type="datetime", nullable=true, options={"default":"CURRENT_TIMESTAMP"})
     */
    public $time;

    /**
     * @ManyToOne(targetEntity="Rotine", cascade={"persist", "remove"})
     * @JoinColumn(name="rotina_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $rotine;

    public function __construct($user1 = '', $user2 = '', $rotine = '') {
        $this->id = '';
        $this->user1 = $user1;
        $this->user2 = $user2;
        $this->time = new \DateTime();
        $this->rotine = $rotine;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;

        return $this;
    }

    public function getUser1() {
        return $this->user1;
    }
    public function setUser1($user1){
        $this->user1 = $user1;

        return $this;
    }

    public function getUser2() {
        return $this->user2;
    }
    public function setUser2($user2){
        $this->user2 = $user2;

        return $this;
    }

    public function getTime() {
        return $this->time;
    }
    public function setTime($time) {
        $this->time = $this->_formatDate($time);

        return $this;
    }

    public function getRotine() {
        return $this->rotine;
    }
    public function setRotine($rotine) {
        $this->rotine = $rotine;

        return $this;
    }

}