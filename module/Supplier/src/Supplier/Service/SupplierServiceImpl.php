<?php

namespace Supplier\Service;

use Supplier\Entity\Supplier;

class SupplierServiceImpl implements SupplierService
{
    /**
     * @var \Supplier\Repository\SupplierRepository $supplierRepository
     */
    protected $supplierRepository;


    /**
     * Saves a article post
     *
     * @param Supplier $supplier
     *
     * @return Supplier
     */
    public function save(Supplier $supplier)
    {
        $this->supplierRepository->save($supplier);
    }

    /**
     * @param $page int
     *
     * @return \Zend\Paginator\Paginator
     */
    public function fetch($page)
    {
        return $this->supplierRepository->fetch($page);
    }

    /**
     * @param $supplierId int
     *
     * @return Suppliers|null
     */
    public function findById($supplierId)
    {
        return $this->supplierRepository->findById($supplierId);
    }

    /**
     * @param Suppliers $supplier
     *
     * @return void
     */
    public function update(Supplier $supplier)
    {
        $this->supplierRepository->update($supplier);
    }

    /**
     * @param $supplierId int
     *
     * @return void
     */
    public function delete($supplierId)
    {
        $this->supplierRepository->delete($supplierId);
    }

    /**
     * @param \Supplier\Repository\SupplierRepository $supplierRepository
     */
    public function setSupplierRepository($supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * @return \Supplier\Repository\SupplierRepository
     */
    public function getSupplierRepository()
    {
        return $this->supplierRepository;
    }
}