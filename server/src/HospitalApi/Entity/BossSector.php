<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Responsavel_Setor")
 * <b>BossSector</b>
 * Classe POJO que contém os atributos de um Chefe de Setor,
 * sendo atributos obrigatórios Nome e E-mail
 */
class BossSector extends SoftdeleteAbstract
{
    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     *      @Column(name="nm_responsavel", type="string", length=255)
     */
    protected $name;

    /**
     * @var String
     *      @Column(type="string", length=255)
     */
    protected $email;

    /**
     * @var Sector
     *      @OneToMany(targetEntity="Sector", mappedBy="id_responsavel_setor")
     */
    protected $Sector;

    public function __construct($id = null, $name = "", $email = "") {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
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

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

}