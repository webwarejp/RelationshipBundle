<?php

namespace Joubjoub\RelationshipBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @todo perform: Form, security, function optimisation, duplicate code, add functions...
 * @TODO perform addUserAction: createNewRelationship with type/status, exist relation
 */
class RelationshipController extends Controller {

    public function listAction() {
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');

        $relationshipList = $relationshipProvider->getAllRelationship();
        $nbRelationship = count($relationshipList); //$relationshipProvider->getNbRelationship();

        return $this->render('JoubjoubRelationshipBundle:Relationship:list.html.twig', array('nbRelation' => $nbRelationship, 'RelationList' => $relationshipList, 'userRelational' => $relationshipProvider->getAuthanticatedUser()));
    }

    public function deleteAction($rid) {
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');
        
        $relation = $relationshipProvider->getRelationship($rid);
        $relationshipProvider->removeRelationship($relation);
        
        return $this->redirect($this->generateUrl('joubjoub_relationship_list'));
    }

    public function addUserAction($uid) {
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');
        
        $userAdded = $relationshipProvider->getUserAdded($uid);
        $relationshipProvider->createNewRelationship($userAdded);
        
        return $this->redirect($this->generateUrl('joubjoub_relationship_list'));
    }

    public function requestAction() {
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');

        $relationRequests = $relationshipProvider->findAllNewRelationRequest();

        $formList = array();
        foreach ($relationRequests as $relationship) {
            $relationshipForm = $this->container->get('joubjoub_relationship.relationship_form_factory')->create($relationship);
            $formList[] = array('relationship' => $relationship, 'form' => $relationshipForm->createView());
        }
        
        return $this->render('JoubjoubRelationshipBundle:Relationship:request.html.twig', array('formList' => $formList, 'RelationList' => $relationRequests, 'userRelational' => $relationshipProvider->getAuthanticatedUser()));
    }

    public function updateAction($rid) {
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');
        $relationship = $relationshipProvider->getRelationship($rid);

        $relationshipForm = $this->container->get('joubjoub_relationship.relationship_form_factory')->create($relationship);
        $formHandler = $this->container->get('joubjoub_relationship.relationship_form_handler');

        if ( $formHandler->process($relationshipForm)) {
            return $this->redirect($this->generateUrl('joubjoub_relationship_list'));
        }
        else {
            throw new \Exception('error updating status');
        }
    }

}
