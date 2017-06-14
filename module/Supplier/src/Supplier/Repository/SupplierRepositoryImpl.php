<?php

namespace Supplier\Repository;

use Supplier\Entity\Hydrator\AddressHydrator;
use Supplier\Entity\Hydrator\SupplierHydrator;
use Supplier\Entity\Supplier;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class SupplierRepositoryImpl implements SupplierRepository
{
    use AdapterAwareTrait;

    public function save(Supplier $supplier)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->insert()
            ->values(array(
                'title' => $supplier->getTitle(),
                'content' => $supplier->getContent(),
                'category_id' => $supplier->getCategory()->getId(),
                'created' => time(),
            ))
            ->into('post');

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }

    public function fetch($page)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
                'supplier_id' => 'supplier_id',
                'supplier_name' => 'supplier_name'
            ))
            ->from(array('sup' => 'suppliers'))
            ->join(
                array('supaddr' => 'supplier_addresses'), // Table name
                'sup.supplier_id = supaddr.supplier_id', // Condition
                array('address_id' => 'address_id'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('addr' => 'addresses'), // Table name
                'addr.address_id = supaddr.address_id', // Condition
                array(
                    'address_line_1' => 'address_line_1',
                    'address_line_2' => 'address_line_2',
                    'town' => 'town',
                    'post_code' => 'post_code',
                    'telephone' => 'telephone',
                    'fax' => 'fax',
                    'email' => 'email'), // Columns
                $select::JOIN_INNER
            );

//-- print_r($sql->buildSqlString($select,$this->adapter)); die();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new SupplierHydrator());
        $hydrator->add(new AddressHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Supplier());
        $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect($select, $this->adapter, $resultSet);
        $paginator = new \Zend\Paginator\Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);

        return $paginator;
    }

    /**
     * @param $supplierId int
     *
     * @return Supplier|null
     */
    public function findById($supplierId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array(
            'suplier_id',
            'name',
        ))
            ->from(array('p' => 'suppliers'))
            ->join(
                array('supaddr' => 'supplier_addresses'), // Table name
                'sup.supplier_id = supaddr.supplier_id', // Condition
                array('address_id' => 'address_id'), // Columns
                $select::JOIN_INNER
            )
            ->join(
                array('addr' => 'addresses'), // Table name
                'addr.address_id = supaddr.address_id', // Condition
                array(
                    'address_line_1' => 'address_line_1',
                    'address_line_2' => 'address_line_2',
                    'town' => 'town',
                    'post_code' => 'post_code',
                    'telephone' => 'telephone',
                    'fax' => 'fax',
                    'email' => 'email') // Columns
            )->where(array(
                'p.suplier_id' => $supplierId,
                'addr.address_id' => 'supaddr.address_id',
            ));

        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        $hydrator = new AggregateHydrator();
        $hydrator->add(new SupplierHydrator());
        $hydrator->add(new AddressHydrator());

        $resultSet = new HydratingResultSet($hydrator, new Suppliers());
        $resultSet->initialize($results);

        return ($resultSet->count() > 0 ? $resultSet->current() : null);
    }

    /**
     * @param Supplier $supplier
     *
     * @return void
     */
    public function update(Supplier $supplier)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $insert = $sql->update('supplier')
            ->set(array(
                'name' => $supplier->getSupplierName()
            ))
            ->where(array(
                'supplier_id' => $supplier->getSupplierId(),
            ));

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }

    /**
     * @param $supplierId int
     *
     * @return void
     */
    public function delete($supplierId)
    {
        $sql = new \Zend\Db\Sql\Sql($this->adapter);
        $delete = $sql->delete()
            ->from('supplier')
            ->where(array(
                'supplier_id' => $supplierId,
            ));

        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();
    }
}