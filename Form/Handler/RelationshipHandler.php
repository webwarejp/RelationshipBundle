<?php

namespace Joubjoub\RelationshipBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

/**
 * @TODO ADD EVENT
 */
class RelationshipHandler {

    Protected $form;
    protected $request;
    Protected $em;

    public function __construct(Form $form, Request $request, EntityManager $em) {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
    }

    public function process() {
        if ($this->request->getMethod() == 'POST') {
            $this->form->handleRequest($this->request);
            if ($this->form->isValid()) {
                $this->onSuccess($this->form->getData());
                return true;
            }
        }
        return false;
    }

    protected function onSuccess($entity) {
        $this->em->persist($entity);
        $this->em->flush();
    }

}
