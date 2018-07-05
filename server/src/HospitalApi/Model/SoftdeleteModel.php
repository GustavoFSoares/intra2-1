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
        $collection = $this->getRepository()->findBy(['c_removed' => 0]);
        
        return $collection;
    }

    public function doUpdate($obj) {
        $obj->setC_removed($obj->isRemoved() ? true : false);
        return parent::doUpdate($obj);
    }
}
