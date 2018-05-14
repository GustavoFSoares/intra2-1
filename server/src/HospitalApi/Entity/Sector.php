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
class Sector extends SoftdeleteAbstract
{
    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     *      @Column(name="nm_setor", type="string", length=255)
     */
    protected $name;

    /**
     * @ManyToOne(targetEntity="BossSector",cascade={"persist", "remove"})
     * @JoinColumn(name="id_responsavel_setor", referencedColumnName="id", nullable=true)
     */
    protected $BossSector;

    /**
     * @ManyToOne(targetEntity="Enterprise",cascade={"persist", "remove"})
     * @JoinColumn(name="id_empresa", referencedColumnName="id", nullable=true)
     */
    protected $Enterprise;

    public function __construct($enterprise, $bossSector, $name = "", $id = 0) {
        parent::__construct();
        $this->id = $id;
        $this->BossSector = $bossSector;
        $this->Enterprise = $enterprise;
        $this->name = $name;
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