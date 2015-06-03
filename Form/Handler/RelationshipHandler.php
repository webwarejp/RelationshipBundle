<?php

namespace Joubjoub\RelationshipBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RequestStack;
use Joubjoub\RelationshipBundle\Model\RelationshipInterface;
use Joubjoub\RelationshipBundle\Relationship;


class RelationshipHandler {

    protected $request;
    protected $provider;
    Protected $relationManager;

    public function __construct(RequestStack $request, Relationship $provider) {
        $this->request = $request->getCurrentRequest();
        $this->provider = $provider;
        $this->relationManager = $provider->getRelationshipManager();
    }

    public function process(Form $form ) {
        if ($this->request->getMethod() == 'POST') {
            $form->handleRequest($this->request);
            if ($form->isValid()) {
                $this->onSuccess($form->getData());
                return true;
            }
        }
        return false;
    }

    protected function onSuccess(RelationshipInterface $relation) {
       $this->relationManager->save($relation);
       return $relation;
    }

}
