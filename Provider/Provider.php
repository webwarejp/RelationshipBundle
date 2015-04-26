<?php

namespace Joubjoub\RelationshipBundle\Provider;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Joubjoub\RelationshipBundle\Manager\RelationshipManager;
use Joubjoub\RelationshipBundle\Manager\UserRelationalManager;
use Joubjoub\RelationshipBundle\Model\RelationshipInterface;

class Provider implements RsProviderInterface {

    protected $relationshipManager;
    protected $userRelationalManager;

    /**
     * 
     * @param relationshipManager $relationshipManager
     * @param userRelationalManager $userRelationalManager
     */
    public function __construct(RelationshipManager $relationshipManager, UserRelationalManager $userRelationalManager) {
        $this->relationshipManager = $relationshipManager;
        $this->userRelationalManager = $userRelationalManager;
    }

    public function createNewRelationship(UserInterface $userRelated) {
        $user = $this->getAuthanticatedUser();
        $relationship = $this->relationshipManager->create($user, $userRelated);
        return $relationship;
    }

    public function getRelationship($id) {
        return $this->relationshipManager->findOneById($id);
    }

    public function removeRelationship(RelationshipInterface $relationship) {
        $this->relationshipManager->remove($relationship);
    }

    public function getNbRelationship() {
        $relationship = $this->getAllRelationship();
        return count($relationship);
    }
    
    public function getAllRelationship() {
        $user = $this->getAuthanticatedUser();
        $relationshipList = $this->relationshipManager->findAllRelationshipByUser($user);
        return $relationshipList;
    }

    public function getAllRelationshipByStatusAndType($type = RelationshipInterface::TYPE_DEFAULT, $status = RelationshipInterface::RELATION_CONFIRMED) {
        $user = $this->getAuthanticatedUser();
        return $this->relationshipManager->findAllRelationshipByUserAndStatusAndType($user, $status, $type);
    }

    public function existRelationship(UserInterface $userAdded) {
        $relationship = $this->relationshipManager->findOneRelationshipBetweenUsers($this->getAuthanticatedUser(), $userAdded);

        return !empty($relationship) ? true : false;
    }

    public function getUserAdded($id) {
        return $this->userRelationalManager->findUserById($id);
    }

    public function getAuthanticatedUser() {
        return $this->userRelationalManager->getAuthanticatedUser();
    }

    
    public function findAllNewRelationRequest($status = RelationshipInterface::RELATION_ASK) {
        $user = $this->getAuthanticatedUser();
        return $this->relationshipManager->findAllRelationshipByUserAndStatus($user, $status);
    }
    
    public function findAllNewRelationRequestByType($status = RelationshipInterface::RELATION_ASK, $type = RelationshipInterface::TYPE_DEFAULT) {
        $user = $this->getAuthanticatedUser();
        return $this->relationshipManager->findAllRelationshipByUserAndStatusAndType($user, $status, $type);
    }
    
    
    
    
    /**
     * 
     * @return type
     */
    public function getRelationshipManager() {
        return $this->relationshipManager;
    }

    /**
     * 
     * @return type
     */
    public function getUserRelationalManager() {
        return $this->userRelationalManager;
    }

}
