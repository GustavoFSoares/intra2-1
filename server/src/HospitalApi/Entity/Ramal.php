<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Ramal")
 * <b>Ramal</b>
 * Classe contendo o objeto dos Ramais cadastrados
 */
class Ramal extends SoftdeleteAbstract
{

    /**
     * @var integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string @Column(name="nu_ramal", type="integer", length=255)
     */
    protected $number;

    /**
     * @var string @Column(name="ds_ramal", type="string", length=255)
     */
    protected $description;

    // /**
    //  * @ManyToOne(targetEntity="Sector",cascade={"persist", "remove"})
    //  * @JoinColumn(name="id_setor")
    //  */
    // protected $Sector;
    /**
     * @var string @Column(name="nm_setor", type="string", length=255)
     */
    protected $sector;

    /**
     * @var string @Column(name="nm_empresa", type="string", length=255)
     */
    protected $enterprise;
    
    public function __construct($id = 0, $number = "", $description = "", $sector = "") {
        parent::__construct();
        $this->id = $id;
        $this->number = $number;
        $this->description = $description;
        $this->sector = $sector;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getNumber() {
        return $this->number;
    }
    public function setNumber($number) {
        $this->number = $number;

        return $this;
    }

    public function getDescription() {
        return $this->description;
    }
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    public function getSector() {
        return $this->sector;
    }
    public function setSector($sector) {
        $this->sector = $sector;

        return $this;
    }

    public function getEnterprise() {
        return $this->enterprise;
    }
    public function setEnterprise($enterprise) {
        $this->enterprise = $enterprise;

        return $this;
    }

}