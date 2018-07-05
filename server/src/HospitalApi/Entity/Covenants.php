<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Convenios")
 */
class Covenants extends SoftdeleteAbstract
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
     *      @Column(name="link", type="text")
     */
    protected $link;


    public function __construct($id = 0, $title = '', $link = '') {
        parent::__construct();
        $this->id = $id;
        $this->title = $title;
        $this->link = $link;
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

    public function getLink() {
        return $this->link;
    }
    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

}