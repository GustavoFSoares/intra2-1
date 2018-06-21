<?php
namespace HospitalApi\Entity;

/**
 * @Entity
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
     * @var string @Column(name="ds_rota", type="string", length=255)
     */
    protected $route;

    /**
     * @var string @Column(name="icone", type="string", length=255)
     */
    protected $classIcon;

    /**
     * Many Users have Many Groupss.
     * @ManyToMany(targetEntity="Groups")
     * @JoinTable(name="Modulo_Grupo",
     *      joinColumns={@JoinColumn(name="module_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="gruop_id", referencedColumnName="id")}
     *      )
     */
    protected $groups;


    public function __construct($id = 0, $name = "", $route = "", $classIcon = "")
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->route = $route;
        $this->classIcon = $classIcon;
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getRoute() {
        return $this->route;
    }
    public function setRoute($route) {
        $this->route = $route;

        return $this;
    }

    public function getClassIcon() {
        return $this->classIcon;
    }
    public function setClassIcon($classIcon) {
        $this->classIcon = $classIcon;

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
}