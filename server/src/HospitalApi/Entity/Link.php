<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 * @Table(name="Link")
 * <b>Link</b>
 * Classe POJO responsável por manter os atributos de um Link,
 * como também fazer as relações e mapeamento com banco de dados
 */
class Link extends SoftdeleteAbstract
{
    
    /**
     * @var integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string @Column(type="string", length=255)
     */
    protected $url;

    /**
     * @var string @Column(name="titulo", type="string", length=255)
     */
    protected $title;

    /**
     * @var string @Column(type="string", length=255)
     */
    protected $icon;

    /**
     * @var boolean @Column(name="link_externo", type="boolean")
     */
    protected $externalLink;

    public function __construct($url = '', $title = '', $icon = '', $externalLink = false) {
        parent::__construct();
        $this->id = 0;
        $this->url = $url;
        $this->title = $title;
        $this->icon = $icon;
        $this->externalLink = $externalLink;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }
    
    public function getUrl() {
        return $this->url;
    }
    public function setUrl($url) {
        $this->url = $url;
        
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;
        
        return $this;
    }

    public function getIcon() {
        return $this->icon;
    }
    public function setIcon($icon) {
        $this->icon = $icon;
        
        return $this;
    }

    public function isExternalLink() {
        return $this->externalLink;
    }
    public function setExternalLink($externalLink) {
        $this->externalLink = $externalLink;
        
        return $this;
    }

}