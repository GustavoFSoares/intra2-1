<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Empresa")
 * <b>Enterprise</b>
 * Classe POJO que mantêm o Nome da Empresa(ou Hospital)
 */
class Enterprise extends EntityAbstract
{
    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     *      @Column(name="nm_empresa", type="string", length=255)
     */
    protected $name;

    /**
     * @var Sector
     *      @OneToMany(targetEntity="Sector", mappedBy="id_empresa")
     */
    protected $Sector;

    public function __construct($id = null, $name = "")
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

}