<?php

namespace Joubjoub\RelationshipBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Joubjoub\RelationshipBundle\Model\RelationshipInterface;

class RelationshipFormFactory {
    
    protected $formFactory;
    protected $formType;
    protected $formName;
    

    public function __construct(FormFactoryInterface $formFactory, $formType, $formName) {
        $this->formFactory = $formFactory;
        $this->formType = $formType;
        $this->formName = $formName;
    }

    public function create(RelationshipInterface $relationship) {
        $formTypeClass = $this->formType;
        $formType = new $formTypeClass();
        return $this->formFactory->createNamed($this->formName, $formType, $relationship);
    }
}