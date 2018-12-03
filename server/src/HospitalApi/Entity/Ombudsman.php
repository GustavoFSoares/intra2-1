<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @\Doctrine\ORM\Mapping\HasLifecycleCallbacks
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
     * @ManyToOne(targetEntity="OmbudsmanUser", cascade={"persist"})
     * @JoinColumn(name="paciente_id", referencedColumnName="id", nullable=true)
     */
    protected $ombudsmanUser;

    /**
     * @var String @Column(name="descricao_paciente", type="text", nullable=true)
     */
    protected $ombudsmanUserDescription;

    /**
     * @var String @Column(name="sugestao_paciente", type="text", nullable=true)
     */
    protected $ombudsmanUserSugestion;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="ouvidor_id", referencedColumnName="id", nullable=true)
     */
    protected $ombudsman;

    /**
     * @var String @Column(name="descricao_ouvidor", type="text", nullable=true)
     */
    protected $ombudsmanDescription;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="gestor_id", referencedColumnName="id", nullable=true)
     */
    protected $manager;

    /**
     * @var String @Column(name="descricao_gestor", type="text", nullable=true)
     */
    protected $managerResponse;

    /**
     * @ManyToOne(targetEntity="OmbudsmanOrigin")
     * @JoinColumn(name="origem_id", referencedColumnName="id")
     */
    protected $origin;

    /**
     * @ManyToMany(targetEntity="OmbudsmanDemands")
     * @JoinTable(name="Ouvidoria_Ouvidoria_Demandas",
     *      joinColumns={@JoinColumn(name="ouvidoria_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn(name="demanda_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     */
    protected $demands;
    
    /**
     * @var @Column(name="tipo", type="string", length=255, nullable=true)
     */
    protected $type;

    /**
     * @var String @Column(name="leito", type="string", nullable=true, length=255)
     */
    protected $bed;

    /**
     * @ManyToOne(targetEntity="Group")
     * @JoinColumn(name="grupo_id", referencedColumnName="id", nullable=true)
     */
    protected $group;
    
    /**
     * @var String @Column(name="resposta_ao_paciente", type="text", nullable=true)
     */
    protected $responseToUser;

    /**
     * @var Datetime @Column(name="data_relato", type="datetime", nullable=true)
     */
    protected $registerTime;

    /**
     * @var Boolean @Column(name="relatado", type="boolean", nullable=true, options={"default":false})
     */
    protected $reported;

    /**
     * @var Boolean @Column(name="paciente_respondido", type="boolean", nullable=true, options={"default":false})
     */
    protected $answered;

    public function __construct($id = '', $origin = null) {
        parent::__construct();
        $this->id = $id;
        $this->ombudsmanUser = null;
        $this->ombudsmanUserDescription = null;
        $this->ombudsmanUserSugestion = null;
        $this->ombudsman = null;
        $this->ombudsmanDescription = null;
        $this->manager = null;
        $this->managerResponse = null;
        $this->origin = $origin;
        $this->demands = new \Doctrine\Common\Collections\ArrayCollection();
        $this->type = null;
        $this->bed = null;
        $this->group = null;
        $this->responseToUser = null;
        $this->registerTime = null;
        $this->reported = false;
        $this->answered = false;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }
    
    public function getOmbudsmanUser() {
        return $this->ombudsmanUser;
    }
    public function setOmbudsmanUser($ombudsmanUser) {
        $this->ombudsmanUser = $ombudsmanUser;
        
        return $this;
    }
    
    public function getOmbudsmanUserDescription() {
        return $this->ombudsmanUserDescription;
    }
    public function setOmbudsmanUserDescription($ombudsmanUserDescription) {
        $this->ombudsmanUserDescription = $ombudsmanUserDescription;
        
        return $this;
    }
    
    public function getOmbudsmanUserSugestion() {
        return $this->ombudsmanUserSugestion;
    }
    public function setOmbudsmanUserSugestion($ombudsmanUserSugestion) {
        $this->ombudsmanUserSugestion = $ombudsmanUserSugestion;
        
        return $this;
    }
    
    public function getOmbudsman() {
        return $this->ombudsman;
    }
    public function setOmbudsman($ombudsman) {
        $this->ombudsman = $ombudsman;
        
        return $this;
    }
    
    public function getOmbudsmanDescription() {
        return $this->ombudsmanDescription;
    }
    public function setOmbudsmanDescription($ombudsmanDescription) {
        $this->ombudsmanDescription = $ombudsmanDescription;
        
        return $this;
    }
    
    public function getManager() {
        return $this->manager;
    }
    public function setManager($manager) {
        $this->manager = $manager;
        
        return $this;
    }
    
    public function getManagerResponse() {
        return $this->managerResponse;
    }
    public function setManagerResponse($managerResponse) {
        $this->managerResponse = $managerResponse;
        
        return $this;
    }
    
    public function getOrigin() {
        return $this->origin;
    }
    public function setOrigin($origin) {
        $this->origin = $origin;
        
        return $this;
    }

    public function getDemands() {
        return $this->demands;
    }

    public function addDemand($demand) {
        $this->demands->add($demand);

        return $this;
    }
    public function removeDemand($demand) {
        $this->demands->removeElement($demand);
        
        return $this;
    }
    public function setDemands($demands) {
        $this->demands = $demands;

        return $this;
    }

    public function getType() {
        return $this->type;
    }
    public function setType($type) {
        $this->type = $type;
        
        return $this;
    }

    public function getBed() {
        return $this->bed;
    }
    public function setBed($bed) {
        $this->bed = $bed;
        
        return $this;
    }

    public function getGroup() {
        return $this->group;
    }
    public function setGroup($group) {
        $this->group = $group;
        
        return $this;
    }
    
    public function getResponseToUser() {
        return $this->responseToUser;
    }
    public function setResponseToUser($responseToUser) {
        $this->responseToUser = $responseToUser;
        
        return $this;
    }
    
    public function getRegisterTime() {
        return $this->registerTime;
    }
    public function setRegisterTime($registerTime) {
        $this->registerTime = $this->_formatDate($registerTime);
        
        return $this;
    }
    
    public function getReported() {
        return $this->respeported;
    }
    public function setReported($respeported) {
        $this->respeported = (Boolean)$respeported;
        
        return $this;
    }    
    
    public function getAnswered() {
        return $this->answered;
    }
    public function setAnswered($answered) {
        $this->answered = (Boolean)$answered;
        
        return $this;
    }
}