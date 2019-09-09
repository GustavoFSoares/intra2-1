<?php
namespace HospitalApi\Entity;
use DateTime;

/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 * @Table(name="cardapio")
 * <b>Cardapio</b>
 */
class Cardapio extends SoftDeleteAbstract 
{

    /**
     *  @var Integer @Id
     *      @Column(name="id", type="bigint", length=20)
     *      @GeneratedValue
     */
    protected $id;

    /**
     * @var Date @Column(name="data", type="date", nullable=true)
     */
    protected $data;

    /**
     * @var String @Column(name="refeicao", type="string", options={ "default": "ALMOÇO"})
     */
    protected $refeicao;

    /**
     * @var String @Column(name="cardapio", type="string", length=450, nullable=true)
     */
    protected $cardapio;



    public function __construct($id = '') {
        parent::__construct();
        $this->id = $id;
        $this->data = new \DateTime();
        $this->data->format('Y-m-d');
        $this->refeicao = 'ALMOÇO';
        $this->cardapio = null;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getData() {
        return $this->data;
    }
    public function setData($data) {
        $this->data = $this->_formatDate($data);

        return $this;
    }

    public function getRefeicao() {
        return $this->refeicao;
    }
    public function setRefeicao($refeicao) {
        $this->refeicao = $refeicao;

        return $this;
    }

    public function getCardapio() {
        return $this->cardapio;
    }
    public function setCardapio($cardapio) {
        $this->cardapio = $cardapio;

        return $this;
    }
}