<?php

namespace Supplier\Controller;

use Supplier\Entity\Supplier;
use Supplier\Form\Add;
use Supplier\Form\Edit;
use Supplier\InputFilter\AddSupplier;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'paginator' => $this->getSupplierService()->fetch($this->params()->fromRoute('page')),
        ));
    }

    public function addAction()
    {
        $form = new Add();
        $variables = array('form' => $form);

        if ($this->request->isPost()) {
            $supplierPost = new Supplier();
            $form->bind($supplierPost);
            $form->setInputFilter(new AddSupplier());
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->getSupplierService()->save($supplierPost);
                $this->flashMessenger()->addSuccessMessage('The post has been added!');
            }
        }

        return new ViewModel($variables);
    }

    /**
     * @return ViewModel
     */
    public function editAction()
    {
        $form = new Edit();

        if ($this->request->isPost()) {
            $supplier = new Supplier();
            $form->bind($supplier);
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->getSupplierService()->update($supplier);
                $this->flashMessenger()->addSuccessMessage('The post has been updated!');
            }
        } else {
            $supplier = $this->getSupplierService()->findById($this->params()->fromRoute('postId'));

            if ($supplier == null) {
                $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);
            } else {
                $form->bind($supplier);
                $form->get('category_id')->setValue($supplier->getAddress()->getId());
                $form->get('slug')->setValue($supplier->getSlug());
                $form->get('id')->setValue($supplier->getId());
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    /**
     * @return Response
     */
    public function deleteAction()
    {
        $this->getSupplierService()->delete($this->params()->fromRoute('postId'));
        $this->flashMessenger()->addSuccessMessage('The post has been deleted!');
        return $this->redirect()->toRoute('article');
    }

    /**
     * @return \Supplier\Service\SupplierService $articleService
     */
    protected function getSupplierService()
    {
        /*
        * todo: ServiceLocatorAwareInterface deprecated
        *      inject all dependancy in controller factory
        */
        return @ $this->getServiceLocator()->get('Supplier\Service\SupplierService');
    }
} 