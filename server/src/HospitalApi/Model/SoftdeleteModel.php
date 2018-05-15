<?php
namespace HospitalApi\Model;

/**
 * <b>SoftDeleteModel</b>
 */
abstract class SoftdeleteModel extends ModelAbstract
{
    /**
     * @method findAll()
     * Sobreescrita do método findAll() da classe ModelAbstract
     * para Tabelas que extendam a Entity SoftDeleteAbstract.
     * O findAll() realiza uma busca considerando remoção lógica(c_removed)
     * @return Collection
     */
    public function findAll() {
        $collection = $this->em->getRepository($this->entityPath)->findBy(['c_removed' => 0]);
        
        return $collection;
    }
}
