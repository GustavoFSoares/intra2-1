<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Usuario")
 * <b>User</b>
 * Classe POJO responsável por manter os atributos de um User,
 * como também fazer as relações e mapeamento com banco de dados
 */
class User extends SoftdeleteAbstract
{

    /**
     * @var String @Id
     *     @Column(name="id", type="string")
     */
    protected $id;

    /**
     * @var String @Column(name="matricula", type="string", options={"default":"00000000"})
     */
    protected $code;

    /**
     * @var String @Column(name="nome", type="string", length=255)
     */
    protected $name;
    
    /**
     * @var String @Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var String @Column(name="nivel", type="string")
     */
    protected $level;
    
    /**
     * @var String @Column(name="ramal", type="string")
     */
    protected $ramal;

    /**
     * @ManyToOne(targetEntity="Group",cascade={"persist", "remove"})
     * @JoinColumn(name="grupo_id", referencedColumnName="id", nullable=true)
     */
    protected $group;

    /**
     * @var String @Column(name="cargo", type="string", options={"default":""})
     */
    protected $occupation;

    /**
     * @var Boolean @Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $admin;

    /**
     * @var Boolean @Column(name="ativo", type="boolean", nullable=true, options={"default":true})
     */
    protected $active;
    
    /**
     * @var Boolean @Column(name="adp", type="boolean", nullable=true, options={"default":false})
     */
    private $byAdp;
    
    /**
     * @var Boolean @Column(name="ad", type="boolean", nullable=true, options={"default":false})
     */
    private $activeDirectory;

    /**
     * @OneToMany(targetEntity="TrainingParticipant", mappedBy="User")
     */
    private $trainingParticipant;

    /**
     * @OneToOne(targetEntity="UserComplement", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $complement;

    public function __construct() {
        parent::__construct();
        $this->id = '';
        $this->code = '';
        $this->name = '';
        $this->email = '';
        $this->level = 1;
        $this->ramal = '';
        $this->group = new Group();
        $this->occupation = '';
        $this->admin = false;
        $this->byAdp = false;
        $this->activeDirectory = false;
        $this->active = true;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getCode() {
        return $this->code;
    }
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    public function getLevel() {
        return $this->level;
    }
    public function setLevel($level) {
        $this->level = $level;

        return $this;
    }

    public function getRamal() {
        return $this->ramal;
    }
    public function setRamal($ramal) {
        $this->ramal = $ramal;

        return $this;
    }

    public function getGroup() {
        return $this->group;
    }
    public function setGroup($group) {
        $this->group = $group;
        
        return $this;
    }

    public function getOccupation() {
        return $this->occupation;
    }
    public function setOccupation($occupation) {
        $this->occupation = $occupation;

        return $this;
    }

    public function getAdmin() {
        return $this->admin;
    }
    public function setAdmin($admin) {
        $this->admin = $admin ? true : false;

        return $this;
    }

    public function getByAdp() {
        return $this->byAdp;
    }
    public function setByAdp($byAdp) {
        $this->byAdp = $byAdp ? true : false;

        return $this;
    }
    
    public function getActiveDirectory() {
        return $this->activeDirectory;
    }
    public function setActiveDirectory($activeDirectory) {
        $this->activeDirectory = $activeDirectory ? true : false;

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

    public function getStudent() {
        return $this->student;
    }
    public function setStudent($student) {
        $this->student = $student ? true : false;

        return $this;
    }

    public function getComplement() {
        return $this->complement;
    }
    public function setComplement($complement) {
        $this->complement = $complement;

        return $this;
    }

}