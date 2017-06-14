<?php

namespace Supplier;

return array(
    'invokables' => array(
        'Supplier\Repository\SupplierRepository' => 'Supplier\Repository\SupplierRepositoryImpl',
    ),

    'factories' => array(
        'Supplier\Service\SupplierService' => function(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
            $articleService = new \Supplier\Service\SupplierServiceImpl();
            $articleService->setSupplierRepository($serviceLocator->get('Supplier\Repository\SupplierRepository'));

            return $articleService;
        },
    ),

    'initializers' => array(
        function($instance, \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
            if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
                $instance->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'));
            }
        },
    ),
);