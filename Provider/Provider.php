<?php

namespace Joubjoub\RelationshipBundle\Provider;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Joubjoub\RelationshipBundle\Provider\RsProviderInterface;
use Joubjoub\RelationshipBundle\Manager\RelationshipManager;
use Joubjoub\RelationshipBundle\Manager\UserRelationalManager;
use Joubjoub\RelationshipBundle\Model\UserRelationalInterface;
use Joubjoub\RelationshipBundle\Model\RelationshipInterface;
use Joubjoub\RelationshipBundle\Security\AuthorizerInterface;

class Provider implements RsProviderInterface {

    protected $relationshipManager;
    protected $userRelationalManager;
    protected $authorizer;

    /**
     * 
     * @param relationshipManager $relationshipManager
     * @param userRelationalManager $userRelationalManager
     */
    public function __construct(RelationshipManager $relationshipManager, UserRelationalManager $userRelationalManager, AuthorizerInterface $authorizer) {
        $this->relationshipManager = $relationshipManager;
        $this->userRelationalManager = $userRelationalManager;
        $this->authorizer = $authorizer;
    }

    public function createNewRelationship(UserRelationalInterface $userRelated) {
       return $this->relationshipManager->create($this->getAuthanticatedUser(), $userRelated);
    }

    public function removeRelationship(RelationshipInterface $relationship) {
        $this->relationshipManager->remove($relationship);
    }

    public function getRelationship($id) {
        return $this->relationshipManager->findOneById($id);
    }

    public function getAllRelationship() {
        return $this->relationshipManager->findAllRelationshipByUser($this->getAuthanticatedUser());
    }

    public function getAllRelationshipByStatusAndType($type = RelationshipInterface::TYPE_DEFAULT, $status = RelationshipInterface::RELATION_CONFIRMED) {
        return $this->relationshipManager->findAllRelationshipByUserAndStatusAndType($this->getAuthanticatedUser(), $status, $type);
    }

    public function findAllNewRelationRequest($status = RelationshipInterface::RELATION_ASK) {
        return $this->relationshipManager->findAllRelationshipByUserAndStatus($this->getAuthanticatedUser(), $status);
    }

    public function findAllNewRelationRequestByType($type = RelationshipInterface::TYPE_DEFAULT, $status = RelationshipInterface::RELATION_ASK) {
        return $this->relationshipManager->findAllRelationshipByUserAndStatusAndType($this->getAuthanticatedUser(), $status, $type);
    }

    public function getNbRelationship() {
        $relationship = $this->getAllRelationship();
        return count($relationship);
    }

    public function getNbRelationshipByStatusAndType($type = RelationshipInterface::TYPE_DEFAULT, $status = RelationshipInterface::RELATION_CONFIRMED) {
        $relationship = $this->getAllRelationshipByStatusAndType($type, $status);
        return count($relationship);
    }

    public function getNbRelationshipRequestByStatusAndType($type = RelationshipInterface::TYPE_DEFAULT, $status = RelationshipInterface::RELATION_ASK) {
        $relationship = $this->findAllNewRelationRequestByType($type, $status);
        return count($relationship);
    }

    public function getUserAdded($id) {
        $userAdded = $this->userRelationalManager->findUserById($id);

        if (!$this->authorizer->canAddUser($userAdded)) {
            throw new AccessDeniedException('You cant add this user');
        }

        return $userAdded;
    }

    public function getAuthanticatedUser() {
        return $this->userRelationalManager->getAuthanticatedUser();
    }

    public function getRelationshipManager() {
        return $this->relationshipManager;
    }

    public function getUserRelationalManager() {
        return $this->userRelationalManager;
    }

}
