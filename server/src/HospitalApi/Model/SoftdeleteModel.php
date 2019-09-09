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
    public function findBy($filters = [], $orders = []) {
        
        if( $this->hadOrders() ) {
            $orders = array_merge($this->_ORDERS, $orders);
        }
        
        if( $this->hadFilters() ) {
            $filters = array_merge($this->_FILTERS, $filters);
        }

        if($this->isInverseOrder()) {
			$orders['id'] = 'DESC';
		}
        $filters['c_removed'] = 0;
        $collection = $this->getRepository()->findBy($filters, $orders);
        
        return $collection;
    }

    public function findById($id, $showRemoved = false) {
        $filters['id'] = $id;
        if(!$showRemoved) {
            $filters['c_removed'] = 0;
        }

        $collection = $this->getRepository()->findOneBy($filters);
        
        return $collection;
    }
    
    public function doUpdate($obj) {
        if( method_exists($obj, 'setC_removed') ) {
            $obj->setC_removed($obj->isRemoved() ? true : false);
        }
        return parent::doUpdate($obj);
    }

    public function changeStatus($id) {
        $entity = $this->getRepository()->find($id);
        $entity->setActive(!$entity->isActive());
        
        return $entity;
    }
}
