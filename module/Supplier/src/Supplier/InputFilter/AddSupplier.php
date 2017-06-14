<?php

namespace Supplier\InputFilter;

use Zend\Filter\FilterChain;
use Zend\Filter\StringTrim;
use Zend\I18n\Validator\Alnum;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;
use Zend\Validator\ValidatorChain;

class AddSupplier extends InputFilter
{
    public function __construct()
    {
        $supplier = new Input('name');
        $supplier->setRequired(true);
        $supplier->setValidatorChain($this->getSuppliernameValidatorChain());
        $supplier->setFilterChain($this->getStringTrimFilterChain());

        $address_line_1 = new Input('address_line_1');
        $address_line_1->setRequired(true);
        $address_line_1->setValidatorChain($this->getAddressLineValidatorChain());
        $address_line_1->setFilterChain($this->getStringTrimFilterChain());

        $town = new Input('town');
        $town->setRequired(true);
        $town->setValidatorChain($this->getTownValidatorChain());
        $town->setFilterChain($this->getStringTrimFilterChain());

        $this->add($supplier);
        $this->add($address_line_1);
        $this->add($town);
    }

    /**
     * @return ValidatorChain
     */
    protected function getTownValidatorChain()
    {
        $stringLength = new StringLength();
        $stringLength->setMin(3);
        $validatorChain = new ValidatorChain();
        $validatorChain->attach($stringLength);

        return $validatorChain;
    }

    /**
     * @return ValidatorChain
     */
    protected function getAddressLineValidatorChain()
    {
        $stringLength = new StringLength();
        $stringLength->setMin(2);

        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new Regex("/^[a-z0-9\\-]+$/"));
        $validatorChain->attach($stringLength);

        return $validatorChain;
    }

    /**
     * @return ValidatorChain
     */
    protected function getSuppliernameValidatorChain()
    {
        $stringLength = new StringLength();
        $stringLength->setMin(5);

        $validatorChain = new ValidatorChain();
        $validatorChain->attach(new Alnum(true));
        $validatorChain->attach($stringLength);

        return $validatorChain;
    }

    /**
     * @return FilterChain
     */
    protected function getStringTrimFilterChain()
    {
        $filterChain = new FilterChain();
        $filterChain->attach(new StringTrim());

        return $filterChain;
    }
} 