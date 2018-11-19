<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Ouvidoria_Demandas")
 * <b>Treinamento</b>
 */
class OmbudsmanDemands extends SoftdeleteAbstract
{

    /**
     * @var Integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string @Column(name="nome", type="string", length=255)
     */
    protected $name;

    /**
     * @var string @Column(name="ativo", type="boolean",  options={"default": true })
     */
    protected $active;

    public function __construct($id = '', $name = '') {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->active = true;
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
    
    public function getActive() {
        return $this->active;
    }
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

}