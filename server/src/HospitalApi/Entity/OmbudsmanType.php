<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Ouvidoria_Tipo")
 * <b>OmbudsmanType</b>
 */
class OmbudsmanType extends SoftdeleteAbstract
{
    
    /**
     * @var Integer @Id
     *     @Column(name="id", type="string", length=255)
     */
    protected $id;

    /**
     * @var String @Column(name="nome", type="string", length=255)
     */
    protected $name;
    
    public function __contruct() {
        parent::__construct();
        $this->id = 0;
        $this->name = '';
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
   
}