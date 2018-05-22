<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Alerta")
 * <b>Alertas</b>
 * Classe POJO responsavel pela gerência dos Eventos Adversos(AdverseEvents)
 * contendo as Descrições (Conduta e Descrição), Identificador do Paciente e
 * os Objetos dos tipos de Evento, Chefe de Setor e Empresa
 */
class Alert extends SoftdeleteAbstract
{
    /**
     * @var integer @Id
     *      @Column(name="id", type="integer")
     *      @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     *      @Column(name="titulo", type="string", length=255)
     */
    protected $title;

    /**
     * @var Text
     *      @Column(name="descricao", type="text")
     */
    protected $description;

    /**
     * @var String
     *      @Column(name="tipo", type="string", length=255)
     */
    protected $type;

    public function __construct($id = 0, $title = '', $description = '', $type = '') {
        parent::__construct();
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->type = $type;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    public function getDescription() {
        return $this->description;
    }
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    public function getComplement() {
        return [
            'description' => $this->description,
            'conduct' => $this->conduct
        ];
    }
    public function setComplement($complement) {
        $this->description = $complement['description'];
        $this->conduct = $complement['conduct'];

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