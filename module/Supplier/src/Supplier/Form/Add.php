<?php

namespace Supplier\Form;

use Supplier\Entity\Hydrator\SupplierHydrator;
use Supplier\Entity\Hydrator\AddressHydrator;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class Add extends Form
{
    public function __construct()
    {
        parent::__construct('add');

        $hydrator = new AggregateHydrator();
        $hydrator->add(new SupplierHydrator());
        $hydrator->add(new AddressHydrator());
        $this->setHydrator($hydrator);

        $supplier = new Element\Text('name');
        $supplier->setLabel('Supplier Name');
        $supplier->setAttribute('class', 'form-control');

        $address = new Element\Text('address_id');
        $address->setLabel('Address Line 1');
        $address->setAttribute('class', 'form-control');


        $submit = new Element\Submit('submit');
        $submit->setValue('Add Supplier');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($supplier);
        $this->add($address);
        $this->add($submit);
    }
} 