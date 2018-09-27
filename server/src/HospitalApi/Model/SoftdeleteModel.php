<?php
namespace HospitalApi\Model;

/**
 * <b>SoftDeleteModel</b>
 */
abstract class SoftdeleteModel extends ModelAbstract
{
    /**
     * @method findBy()
     * Sobreescrita do método findBy() da classe ModelAbstract
     * para Tabelas que extendam a Entity SoftDeleteAbstract.
     * O findBy() realiza uma busca considerando remoção lógica(c_removed)
     * @return Collection
     */
    public function findBy($filters = []) {
        if(isset($filters['c_removed'])) {
            unset($filters['c_removed']);
        } else {
            $filters['c_removed'] = 0;
        }
        
        $collection = $this->getRepository()->findBy($filters);
        
        return $collection;
    }

    public function doUpdate($obj) {
        $obj->setC_removed($obj->isRemoved() ? true : false);
        return parent::doUpdate($obj);
    }
}
