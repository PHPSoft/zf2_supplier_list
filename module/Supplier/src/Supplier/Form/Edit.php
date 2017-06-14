<?php

namespace Supplier\Form;

use Supplier\Entity\Hydrator\SupplierHydrator;
use Supplier\Entity\Hydrator\AddressHydrator;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class Edit extends Form
{
    public function __construct()
    {
        parent::__construct('edit');

        $hydrator = new AggregateHydrator();
        $hydrator->add(new AddressHydrator());
        $hydrator->add(new SupplierHydrator());
        $this->setHydrator($hydrator);

        $supplier_id = new Element\Hidden('supplier_id');

        $name = new Element\Text('name');
        $name->setLabel('Supplier Name');
        $name->setAttribute('class', 'form-control');

        $address= new Element\Text('address_id');
       $address->setLabel('Address Line 1');
       $address->setAttribute('class', 'form-control');
       $address->setValueOptions(array(
        ));

        $submit = new Element\Submit('submit');
        $submit->setValue('Add Supplier');
        $submit->setAttribute('class', 'btn btn-primary');

        $this->add($supplier_id);
        $this->add($name);
        $this->add($address);
        $this->add($submit);
    }
}