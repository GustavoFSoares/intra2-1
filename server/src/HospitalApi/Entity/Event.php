<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Evento")
 * <b>Events</b>
 * Classe POJO descrição dos <b>Tipos<b> de Evento Adversos possíveis
 */
class Event extends SoftdeleteAbstract
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
    protected $description;

    public function __construct($description = "") {
        $this->description = $description;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getDescription() {
        return $this->description;
    }
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

}