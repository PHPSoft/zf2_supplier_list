<?php

namespace Supplier\Entity\Hydrator;

use Supplier\Entity\Supplier;
use Zend\Stdlib\Hydrator\HydratorInterface;

class SupplierHydrator implements HydratorInterface
{
    /**
     * Extract values from an object
     *
     * @param  object $object
     *
     * @return array
     */
    public function extract($object)
    {
        if (!$object instanceof Supplier) {
            return array();
        }

        return array(
            'supplier_id' => $object->getSupplierId(),
            'supplier_name' => $object->getSupplierName()
        );
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     *
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof Supplier) {
            return $object;
        }

        $object->setSupplierId(isset($data['supplier_id']) ? intval($data['supplier_id']) : null);
        $object->setSupplierName(isset($data['supplier_name']) ? $data['supplier_name'] : null);
        return $object;
    }
}