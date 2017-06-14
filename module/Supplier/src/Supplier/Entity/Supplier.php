<?php

namespace Supplier\Entity;

class Supplier
{
    /**
     * @var int
     */
    protected $supplier_id;

    /**
     * @var string
     */
    protected $supplier_name;

    /**
     * @var address
     */
    protected $address;


    /**
     * @param string $supplier_name
     */
    public function setSupplierName($supplier_name)
    {
        $this->supplier_name = $supplier_name;
    }

    /**
     * @return string
     */
    public function getSupplierName()
    {
        return $this->supplier_name;
    }

    /**
     * @param int $supplier_id
     */
    public function setSupplierId($supplier_id)
    {
        $this->supplier_id = $supplier_id;
    }

    /**
     * @return int
     */
    public function getSupplierId()
    {
        return $this->supplier_id;
    }

    /**
     * @param Address|Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return \Supplier\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }
}