<?php
namespace HospitalApi\Entity;

/**
 * @Entity
 * @Table(name="Treinamento_Participante")
 * <b>Treinamento</b>
 */
class TrainingParticipant extends EntityAbstract
{

    /**
     * @var integer @Id
     *     @Column(name="id", type="integer")
     *     @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Training", inversedBy="TrainingParticipant", cascade={"persist", "remove"})
     * @JoinColumn(name="treinamento_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $training;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="TrainingParticipant", cascade={"persist", "remove"})
     * @JoinColumn(name="participante_id", nullable=false, onDelete="CASCADE")
     */
    protected $participant;

    /**
     * @var Boolean @Column(name="presensa", type="boolean", options={"default" : false})
     */
    protected $presence;

    public function __construct() {
        parent::__construct();
        $this->training = new Training();
        $this->participant = new User();
        $this->presence = false;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getTraining() {
        return $this->training;
    }
    public function setTraining($training) {
        $this->training = $training;

        return $this;
    }

    public function getParticipant() {
        return $this->participant;
    }
    public function setParticipant($participant) {
        $this->participant = $participant;

        return $this;
    }

    public function getPresence() {
        return $this->presence;
    }
    public function setPresence($presence) {
        $this->presence = $presence;

        return $this;
    }

}