<?php 
namespace HospitalApi\Model;

use HospitalApi\Entity\OmbudsmanMessages;

/**
 * <b>EmailModel</b>
 */
class OmbudsmanMessagesModel extends ModelAbstract
{

    public function __construct($values = null) {
        $this->entity = new OmbudsmanMessages();
        if($values) {
            $this->mount($values);
        }
        parent::__construct();
    }
    
    public function mount($values) {
        $values->ombudsman = [ 'id' => $values->id ];
        unset($values->id);

        foreach ($values as $key => $value) {
			$method = "set$key";
			$this->entity->$method($value);
        }
        
        return $this->entity;
    }

    public function findMessagesByOmbudsman($idOmbudsman) {
        $ombudsmanModel = new \HospitalApi\Model\OmbudsmanModel();

        $select = $this->em->createQueryBuilder();
        $select
            ->select([
                'om.message',
                'u.name as user',
                'om.time',
                'om.read',
                ])
            ->from($this->getEntityPath(), 'om')
            ->innerJoin('om.ombudsman', 'o', 'WITH', 'o = :ombudsmanId')
            ->innerJoin('HospitalApi\Entity\User', 'u', 'WITH', 'u = om.user')
            ->setParameter('ombudsmanId', $idOmbudsman);
        $select = $ombudsmanModel->showForJustWhoCanSee($select);
        return $select->getQuery()->getResult();
    }

    public function deleteChats($idOmbudsman) {
        $query = $this->em->createQueryBuilder();
        $query
            ->delete($this->getEntityPath(), 'om')
            ->where('om.ombudsman = :ombudsmanId')
            ->setParameter('ombudsmanId', $idOmbudsman);
        $query->getQuery()->execute();
    }

}
