<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="link")
 */
class Link extends EntityAbstract
{
    
        /**
     * @var integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    // public $id;

    /**
     * @var string @Column(type="string", length=255)
     */
    protected $url;
    // public $url;

    /**
     * @var string @Column(type="string", length=255)
     */
    protected $title;
    // public $title;

    /**
     * @var string @Column(type="string", length=255)
     */
    protected $icon;
    // public $icon;

    /**
     * @var boolean @Column(type="boolean")
     */
    protected $externalLink;
    // public $externalLink;

    public function __contruct($url = '', $title = '', $icon = '', $externalLink = false){
        $this->id = 0;
        $this->url = $url;
        $this->title = $title;
        $this->icon = $icon;
        $this->externalLink = $externalLink;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
        
        return $this;
    }
    
    public function getUrl(){
        return $this->url;
    }
    public function setUrl($url){
        $this->url = $url;
        
        return $this;
    }

    public function getTitle(){
        return $this->title;
    }
    public function setTitle($title){
        $this->title = $title;
        
        return $this;
    }

    public function getIcon(){
        return $this->icon;
    }
    public function setIcon($icon){
        $this->icon = $icon;
        
        return $this;
    }

    public function isExternalLink(){
        return $this->externalLink;
    }
    public function setExternalLink($externalLink){
        $this->externalLink = $externalLink;
        
        return $this;
    }

}