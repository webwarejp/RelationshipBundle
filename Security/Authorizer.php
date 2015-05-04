<?php

namespace Joubjoub\RelationshipBundle\Security;

use Joubjoub\RelationshipBundle\Security\AuthorizerInterface;
use Joubjoub\RelationshipBundle\Manager\UserRelationalManager;
use Joubjoub\RelationshipBundle\Manager\RelationshipManager;
use Joubjoub\RelationshipBundle\Model\UserRelationalInterface;

class Authorizer implements AuthorizerInterface {

    /**
     *
     * @var UserRelationalManager
     */
    protected $userRelationalManager;

    /**
     *
     * @var RelationshipManager 
     */
    protected $relationshipManager;

    public function __construct(UserRelationalManager $userRelationalManager, RelationshipManager $relationshipManager) {
        $this->userRelationalManager = $userRelationalManager;
        $this->relationshipManager = $relationshipManager;
    }

    /**
     *
     * @param UserRelationalInterface $userAdded
     * @return boolean
     */
    public function canAddUser(UserRelationalInterface $userAdded) {
        $isSameUser = $this->getAuthenticatedUser() === $userAdded ? true : false;
        if ($isSameUser) {
            return false;
        }
        return $this->existRelationship($userAdded) ? false : true;
    }

    /**
     * 
     * @param UserRelationalInterface $userAdded
     * @return Boolean
     */
    public function existRelationship(UserRelationalInterface $userAdded) {
        $relationship = $this->relationshipManager->findOneRelationshipBetweenUsers($this->getAuthenticatedUser(), $userAdded);
        return !empty($relationship) ? true : false;
    }

    /**
     *
     * @return UserInterface
     */
    protected function getAuthenticatedUser() {
        return $this->userRelationalManager->getAuthanticatedUser();
    }

}
