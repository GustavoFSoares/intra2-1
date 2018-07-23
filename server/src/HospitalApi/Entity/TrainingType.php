<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Treinamento_Tipo")
 * <b>Treinamento</b>
 */
class TrainingType extends SoftdeleteAbstract
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

    public function __construct($id = '', $name = '') {
        parent::__construct();
        $this->id = $id;
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

}