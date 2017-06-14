<?php

namespace Supplier\Repository;

use Application\Repository\RepositoryInterface;
use Supplier\Entity\Supplier;

interface SupplierRepository extends RepositoryInterface
{
    /**
     * Saves a article post
     *
     * @param Supplier $supplier
     *
     * @return void
     */
    public function save(Supplier $supplier);

    /**
     * @param $page int
     *
     * @return \Zend\Paginator\Paginator
     */
    public function fetch($page);

    /**
     * @param $supplierId int
     *
     * @return Suppliers|null
     */
    public function findById($supplierId);

    /**
     * @param Supplier $supplier
     *
     * @return void
     */
    public function update(Supplier $supplier);

    /**
     * @param $supplierId int
     *
     * @return void
     */
    public function delete($supplierId);
}