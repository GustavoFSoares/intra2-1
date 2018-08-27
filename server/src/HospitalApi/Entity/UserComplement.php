<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Usuario_Complemento")
 * <b>UserComplement</b>
 */
class UserComplement extends EntityAbstract
{

    /**
     * @var Integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="User", inversedBy="complement", cascade={"persist", "remove"})
     * @JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var String @Column(name="entidade", type="string", length=255)
     */
    protected $entity;

    /**
     * @var Datetime
     *      @Column(name="data_contratacao", type="datetime", nullable=true, options={"default":"CURRENT_TIMESTAMP"})
     */
    public $hire;

    /**
     * @var Datetime
     *      @Column(name="data_demissao", type="datetime", nullable=true, options={"default":"CURRENT_TIMESTAMP"})
     */
    public $fire;
   
    /**
     * @var String
     *      @Column(name="turno", type="string", nullable=true, options={"default":""})
     */
    public $turn;
    
    /**
     * @ManyToOne(targetEntity="UserType", cascade={"persist", "remove"})
     * @JoinColumn(name="tipo_id", referencedColumnName="id")
     */
    public $type;

    public function __construct($id = '', $entity = '') {
        $this->id = $id;
        $this->user = '';
        $this->entity = $entity;
        $this->hire = new \DateTime();
        $this->fire = new \DateTime();
        $this->turn = '';
        $this->type = '';
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;

        return $this;
    }

    public function getUser() {
        return $this->user;
    }
    public function setUser($user){
        $this->user = $user;

        return $this;
    }

    public function getEntity() {
        return $this->entity;
    }
    public function setEntity($entity){
        $this->entity = $entity;

        return $this;
    }

    public function getHire() {
        return $this->hire;
    }
    public function setHire($hire) {
        $this->hire = $this->_formatDate($hire);

        return $this;
    }

    public function getFire() {
        return $this->fire;
    }
    public function setFire($fire) {
        $this->fire = $this->_formatDate($fire);

        return $this;
    }

    public function getTurn() {
        return $this->turn;
    }
    public function setTurn($turn) {
        $this->turn = $turn;

        return $this;
    }

    public function getType() {
        return $this->type;
    }
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

}