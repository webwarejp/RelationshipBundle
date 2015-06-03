<?php

namespace Joubjoub\RelationshipBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 *
 * exemples
 */
class RelationshipController extends Controller {

    public function listAction() {
        $linker = $user = $this->get('security.context')->getToken()->getUser();
        
        $relationshipProvider = $this->container->get('joubjoub_relationship.provider');
        $relationshipList = $relationshipProvider->setLinker($linker)->getRelationships();
        
        return $this->render('JoubjoubRelationshipBundle:Relationship:list.html.twig', array(
            'nbRelation' => count($relationshipList), 
            'RelationList' => $relationshipList, 
            'linker' => $linker));
    }

    public function addAction($linkedId) {
        $linker = $user = $this->get('security.context')->getToken()->getUser();
               
        $linkerManager = $this->container->get('joubjoub_relationship.linker_manager');
        $linked = $linkerManager->findLinkableById($linkedId)->getLinkable();
        
        $relationship = $this->container->get('joubjoub_relationship.provider');
        $relationship->create($linker, $linked);
        
        return $this->redirect($this->generateUrl('joubjoub_relationship_list'));
    }

    public function deleteAction($rid) {
        $relationship = $this->container->get('joubjoub_relationship.provider');
        $link = $relationship->getRelationship($rid);
        $relationship->remove($link);
        return $this->redirect($this->generateUrl('joubjoub_relationship_list'));
    }
    
    public function requestAction() {
        $linker = $user = $this->get('security.context')->getToken()->getUser();
        
        $relationship = $this->container->get('joubjoub_relationship.provider');
        $relationRequests = $relationship->setLinker($linker)->getRelationshipsByStatusAndType();

        $formList = array();
        foreach ($relationRequests as $relationship) {
            $relationshipForm = $this->container->get('joubjoub_relationship.relationship_form_factory')->create($relationship);
            $formList[] = array('relationship' => $relationship, 'form' => $relationshipForm->createView());
        }
        
        return $this->render('JoubjoubRelationshipBundle:Relationship:request.html.twig', array('formList' => $formList, 'RelationList' => $relationRequests, 'linker' => $relationship->getLinker()));
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
