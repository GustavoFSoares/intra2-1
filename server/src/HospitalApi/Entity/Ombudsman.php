<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Ouvidoria")
 * <b>Ombudsman</b>
 */
class Ombudsman extends SoftdeleteAbstract
{
    
    /**
     * @var Integer @Id
     *     @Column(name="id", type="string", length=255)
     */
    protected $id;

    /**
     * @var Datetime @Column(name="data_registro", type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected $register;

    /**
     * @var String @Column(name="tipo", type="string", length=255, nullable=true)
     */
    protected $type;
    
    /**
     * @ManyToOne(targetEntity="Group")
     * @JoinColumn(name="grupo_id", referencedColumnName="id", nullable=true)
     */
    protected $group;
    
    /**
     * @ManyToOne(targetEntity="OmbudsmanUser", cascade={"persist"})
     * @JoinColumn(name="ombudsman_user_id", referencedColumnName="id", nullable=true)
     */
    protected $ombudsmanUser;
    
    /**
     * @ManyToOne(targetEntity="OmbudsmanType")
     * @JoinColumn(name="origem_id", referencedColumnName="id")
     */
    protected $origin;
    
    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="ouvidor_id", referencedColumnName="id", nullable=true)
     */
    protected $ombudsman;
    
    /**
     * @var String @Column(name="leito", type="string", nullable=true, length=255)
     */
    protected $bed;
    
    /**
     * @var Boolean @Column(name="relatado", type="boolean")
     */
    protected $reported;

    /**
     * @var String @Column(name="descricao", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var String @Column(name="sugestao", type="text", nullable=true)
     */
    protected $sugestion;

    /**
     * @var String @Column(name="descricao_ouvidor", type="string")
     */
    protected $ombudsmanDescription;

    public function __contruct($url = '', $title = '', $icon = '', $externalLink = false) {
        parent::__construct();
        $this->id = '';
        $this->register = new \DateTime();
        $this->type = '';
        $this->group = null;
        $this->ombudsmanUser = null;
        $this->origin = null;
        $this->user = null;
        $this->bed = null;
        $this->reported = false;
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