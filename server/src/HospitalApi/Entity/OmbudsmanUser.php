<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Ouvidoria_Usuario")
 * <b>OmbudsmanUser</b>
 */
class OmbudsmanUser extends SoftdeleteAbstract
{
    
    /**
     * @var Integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String @Column(name="nome_paciente", type="string", length=255)
     */
    protected $patientName;
    
    /**
     * @var String @Column(name="nome_declarante", type="string", length=255)
     */
    protected $declarantName;

    /**
     * @var Datetime @Column(name="data_nascimento", type="datetime")
     */
    protected $birthday;

    /**
     * @var String @Column(type="string", nullable=true)
     */
    protected $email;
    
    /**
     * @var String @Column(name="telefone", type="string", nullable=true)
     */
    protected $phoneNumber;
    
    /**
     * @var String @Column(name="endereco", type="string", nullable=true)
     */
    protected $address;

    public function __contruct() {
        parent::__construct();
        $this->id = 0;
        $this->patientName = '';
        $this->declarantName = '';
        $this->birthday = new \DateTime();
        $this->email = null;
        $this->phoneNumber = '';
        $this->address = '';
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }
   
    public function getPatientName() {
        return $this->patientName;
    }
    public function setPatientName($patientName) {
        $this->patientName = $patientName;
        
        return $this;
    }
   
    public function getDeclarantName() {
        return $this->declarantName;
    }
    public function setDeclarantName($declarantName) {
        $this->declarantName = $declarantName;
        
        return $this;
    }
    
    public function getBirthday() {
        return $this->birthday;
    }
    public function setBirthday($birthday) {
        $this->birthday = $birthday;
        
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
        
        return $this;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }
    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
        
        return $this;
    }

    public function getAddress() {
        return $this->address;
    }
    public function setAddress($address) {
        $this->address = $address;
        
        return $this;
    }

}