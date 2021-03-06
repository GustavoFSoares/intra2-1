<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
 * @Table(name="Modulo")
 */
class Module extends SoftdeleteAbstract
{

    /**
     * @var integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string @Column(name="nm_modulo", type="string", length=255)
     */
    protected $name;

    /**
     * @var string @Column(name="ds_nome_rota", type="string", length=255)
     */
    protected $routeName;

    /**
     * @var string @Column(name="padrao", type="boolean", options={"default": false })
     */
    protected $default;

    /**
     * @var string @Column(name="icone", type="string", length=255)
     */
    protected $icon;

    /**
     * @OneToMany(targetEntity="Module", mappedBy="parent", cascade={"persist"})
     */
    protected $children;

     /**
     * @ManyToOne(targetEntity="Module", inversedBy="children", cascade={"persist"})
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * Many Modules have Many Groupss.
     * @ManyToMany(targetEntity="Group")
     * @JoinTable(name="Modulo_Grupo",
     *      joinColumns={@JoinColumn(name="modulo_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn(name="grupo_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    protected $groups;

    /**
     * @var Boolean @Column(name="ativo", type="boolean", nullable=true, options={"default":true})
     */
    protected $active;


    public function __construct($id = 0, $name = "", $routeName = "", $icon = "")
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->routeName = $routeName;
        $this->icon = $icon;
        $this->active = true;
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getRouteName() {
        return $this->routeName;
    }
    public function setRouteName($routeName) {
        $this->routeName = $routeName;

        return $this;
    }

    public function getIcon() {
        return $this->icon;
    }
    public function setIcon($icon) {
        $this->icon = $icon;

        return $this;
    }
    
    public function getDefault() {
        return $this->default;
    }
    public function setDefault($default) {
        $this->default = $default;

        return $this;
    }

    public function getGroups() {
        return $this->groups;
    }
    public function addGroup($groups) {
        $this->groups->add($groups);

        return $this;
    }
    public function removeGroup($groups) {
        $this->groups->removeElement($groups);
        
        return $this;
    }
    public function setGroups($groups) {
        $this->groups = $groups;

        return $this;
    }
    
    public function getChildren() {
        return $this->children;
    }
    public function addChildren($children) {
        $this->children->add($children);

        return $this;
    }
    public function removeChildren($children) {
        $this->children->removeElement($children);
        
        return $this;
    }
    public function setChildren($children) {
        $this->children = $children;

        return $this;
    }

    public function getParent() {
        return $this->parent;
    }
    public function setParent($parent) {
        if( is_integer($parent) ) {
            $this->parent = $this->getEntityManager()->getRepository('HospitalApi\Entity\Module')->find($parent);
        } else {
            $this->parent = $parent;
        }

        return $this;
    }

    public function isActive() {
        return $this->getActive();
    }
    public function getActive() {
        return $this->active;
    }
    public function setActive($active) {
        $this->active = $active ? true : false;

        return $this;
    }
}