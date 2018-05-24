<?php 
namespace HospitalApi\Model;

use HospitalApi\Entity\AdverseEvents;
use HospitalApi\Entity\Enterprise;
use HospitalApi\Entity\Sector;
use HospitalApi\Entity\Event;
use HospitalApi\Entity\BossSector;

/**
 * <b>EmailModel</b>
 */
class AdverseEventsModel extends ModelAbstract
{

    public function __construct() {
        $enterprise = new Enterprise();
        $event = new Event();
        
        $bossSector = new BossSector();
        $sector = new Sector($enterprise, $bossSector);

        $this->entity = new AdverseEvents($enterprise, $sector, $event);
        parent::__construct();
    }

    /**
     * @method buildData()
     * Realiza inserção no de novos Eventos relatados no Banco de Dados.
     * O buildData recebe um $data com Objeto de AdverseEvents, busca as
     * tabelas relacionadas correspondentes e cria um novo EventoAdverso para
     * fazer inserção.
     * @param AdverseEvents $data
     * @return Array Status
     */
    public function buildData($data) {
        
        try {
            //Busca Referência das Tabelas Relacionadas
            $enterpriseRepository = $this->em->getRepository('HospitalApi\Entity\Enterprise');
            $sectorRepository = $this->em->getRepository('HospitalApi\Entity\Sector');
            $eventRepository = $this->em->getRepository('HospitalApi\Entity\Event');
            
            //Retorna representação das Tabelas Relacionadas
            $enterprise = $enterpriseRepository->find($data->enterprise['id']);
            $sector = $sectorRepository->find($data->sector? $data->sector['id']:'');
            $event = $eventRepository->find($data->event['id']);
            
            $adverseEvent = new AdverseEvents($enterprise, $sector, $event);
            $adverseEvent
                ->mustReturn($data->mustReturn)
                ->setComplement($data->complement)
                ->setPatient($data->patient)
                ->setEventTime($data->eventTime);
            $this->doInsert($adverseEvent);

            return ['status' => true ];
        } catch (Execption $e) {
            return [ 'status' => false, 'error' => $e->getMessage() ];
        }
        
    }

}
