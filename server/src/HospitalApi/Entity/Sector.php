<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Setor")
 * <b>Sector</b>
 * Classe POJO responsável por manter os atributos da tabela Setor,
 * onde constam o Nome do Setor, o Objeto dos Chefes de Setor(BossSector)
 * e Objeto com as Empresas(Enterprise)
 */
class Sector extends EntityAbstract
{
    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     *      @Column(name="ds_evento", type="string", length=255)
     */
    protected $name;

    /**
     * @OneToOne(targetEntity="BossSector",cascade={"persist"})
     * @JoinColumn(name="id_resposavel_setor", referencedColumnName="id")
     */
    protected $BossSector;

    /**
     * @ManyToOne(targetEntity="Enterprise",cascade={"persist"})
     * @JoinColumn(name="id_empresa", referencedColumnName="id")
     */
    protected $Enterprise;

    public function __construct($name = "", $bossName, $enterpriseName) {
        $this->name = $name;
        $this->BossSector = $bossName;
        $this->Enterprise = $enterpriseName;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
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

    public function getBossSector() {
        return $this->BossSector;
    }

    public function getEnterprise() {
        return $this->Enterprise;
    }
}