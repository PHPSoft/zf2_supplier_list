<?php

namespace Supplier\Entity\Hydrator;

use Supplier\Entity\Address;
use Supplier\Entity\Supplier;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AddressHydrator implements HydratorInterface
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
        if (!$object instanceof Supplier || $object->getAddress() == null) {
            return array();
        }

        $address = $object->getAddress();

        return array(
            'address_id'     => $address->getAddressId(),
            'address_line_1' => $address->getAddressLine1(),
            'address_line_2' => $address->getAddressLine2(),
            'town'           => $address->getTown(),
            'post_code'      => $address->getPostCode(),
            'telephone'      => $address->getTelephone(),
            'fax'            => $address->getFax(),
            'email'          => $address->getEmail()
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

        $address = new Address();
        $address->setAddressId(isset($data['address_id']) ? intval($data['address_id']) : null);
        $address->setAddressLine1(isset($data['address_line_1']) ? $data['address_line_1'] : null);
        $address->setAddressLine2(isset($data['address_line_2']) ? $data['address_line_2'] : null);
        $address->setTown(isset($data['town']) ? $data['town'] : null);
        $address->setPostCode(isset($data['post_code']) ? $data['post_code'] : null);
        $address->setTelephone(isset($data['telephone']) ? $data['telephone'] : null);
        $address->setFax(isset($data['fax']) ? $data['fax'] : null);
        $address->setEmail(isset($data['email']) ? $data['email'] : null);
        $object->setAddress($address);

        return $object;
    }
} 