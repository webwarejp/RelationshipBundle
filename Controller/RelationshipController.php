<?php

namespace Joubjoub\RelationshipBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Joubjoub\RelationshipBundle\Form;
use Joubjoub\RelationshipBundle\Form\Handler\RelationshipHandler;

/**
 * @todo perform: Form, security, function optimisation, duplicate code, add functions...
 */
class RelationshipController extends Controller {

    public function listAction() {
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');

        $nbRelationship = $relationshipProvider->getNbRelationship();
        
        $userRelational = $relationshipProvider->getAuthanticatedUser();
        $relationshipList = $relationshipProvider->getAllRelationship();

        return $this->render('JoubjoubRelationshipBundle:Relationship:list.html.twig', array('nbRelation' => $nbRelationship , 'RelationList' => $relationshipList, 'userRelational' => $userRelational));
    }

    public function deleteAction($rid) {
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');
        $relation = $relationshipProvider->getRelationship($rid);
        $relationshipProvider->removeRelationship($relation);
        return $this->redirect($this->generateUrl('joubjoub_relationship_list'));
    }

    /**
     * @TODO perform createNewRelationship with type/status, perform exist relation
     * @param type $uid
     * @throws \LogicException
     */
    public function addUserAction($uid) {
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');
        $userRelational = $relationshipProvider->getAuthanticatedUser();
        $userAdded = $relationshipProvider->getUserAdded($uid);

        if ($userRelational === $userAdded) {
            throw new \LogicException('you cant add yourself');
        }
        if ($relationshipProvider->existRelationship($userAdded)) {
            throw new \LogicException('you already have added this user');
        }

        $relationshipProvider->createNewRelationship($userAdded);
        return $this->redirect($this->generateUrl('joubjoub_relationship_list'));
    }
    
    public function requestAction() {
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');
        $userRelational = $relationshipProvider->getAuthanticatedUser();

        $relationRequests = $relationshipProvider->findAllNewRelationRequest();
        $formList = array();
        foreach ($relationRequests as $relationship) {
            $relationshipForm = $this->createForm(new Form\RelationshipType($relationshipProvider), $relationship);
            $formList[] = array('relationship' => $relationship,  'form' => $relationshipForm->createView());
        }
        return $this->render('JoubjoubRelationshipBundle:Relationship:request.html.twig', array('formList' => $formList, 'RelationList' => $relationRequests, 'userRelational' => $userRelational));
    }
    
    /**
     * Security => asker cant be there
     * @param type $rid
     * @return type
     * @throws \Exception
     */
    public function updateAction($rid) {
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');
        $relationship = $relationshipProvider->getRelationship($rid);
        
        $relationshipForm = $this->createForm(new Form\RelationshipType($relationshipProvider), $relationship);
        $formHandler = new RelationshipHandler($relationshipForm,  $this->get('request'),  $this->getDoctrine()->getManager());
        $process = $formHandler->process();
        
        if ($process) {
            return $this->redirect($this->generateUrl('joubjoub_relationship_list'));
        }
        else {
            throw new \Exception('error updating status');
        }
    }

}
