<?php 
namespace HospitalApi\Model;

use HospitalApi\Entity\AdverseEvents;
use HospitalApi\Entity\Enterprise;
use HospitalApi\Entity\Sector;
use HospitalApi\Entity\Event;
use HospitalApi\Entity\BossSector;

/**
 * <b>EmailModel</b>
 * Classe responsável pela estruturação do Email
 * como também realizar o envio do mesmo
 */
class AdverseEventsModel extends ModelAbstract
{

    public $s;

    public function __construct() {
        $enterprise = new Enterprise();
        $event = new Event();
        
        $bossSector = new BossSector();
        $sector = new Sector($enterprise, $bossSector);

        $this->entity = new AdverseEvents($enterprise, $sector, $event);
        parent::__construct();
    }

    public function buildData($data) {
        
        // $bossSector = $bossSectorRepository->find(1);
        // $bossSectorRepository = $this->em->getRepository('HospitalApi\Entity\BossSector');
        try {
            $enterpriseRepository = $this->em->getRepository('HospitalApi\Entity\Enterprise');
            $sectorRepository = $this->em->getRepository('HospitalApi\Entity\Sector');
            $eventRepository = $this->em->getRepository('HospitalApi\Entity\Event');
    
            $enterprise = $enterpriseRepository->find($data->enterprise);
            $sector = $sectorRepository->find($data->setor);
            $event = $eventRepository->find($data->event);
            
            $adverseEvent = new AdverseEvents($enterprise, $sector, $event);
            $adverseEvent
                ->mustReturn($data->mustReturn)
                ->setComplement($data->complement)
                ->setPatient($data->patient);
            $this->insert($adverseEvent);
            
            return ['status' => true ];
        } catch (Execption $e) {
            return [ 'status' => false, 'error' => $e->getMessage() ];
        }


        
    }

}
