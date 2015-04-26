<?php

namespace Joubjoub\RelationshipBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Joubjoub\RelationshipBundle\Manager\BaseManager;
use Joubjoub\RelationshipBundle\Provider\UserProviderInterface;
use Joubjoub\RelationshipBundle\Model\UserRelationalInterface;

class UserRelationalManager extends BaseManager {

    /**
     * The security context
     *
     * @var UserProviderInterface
     */
    protected $userProvider;

    public function __construct(UserProviderInterface $userProvider, EntityManagerInterface $em, $class) {
        parent::__construct($em, $class);
        $this->userProvider = $userProvider;
    }

    
    public function findUserById ($id) {
        $user = $this->repository->findOneById($id);
        return $this->checkAuthanticity($user);
    }
    
    /**
     * Gets the current authanticated user
     *
     * @return UserRelationalInterface
     */
    public function getAuthanticatedUser() {
        $user = $this->userProvider->getAuthanticatedUser();
        return $this->checkAuthanticity($user);
    }

    /**
     * 
     * @param UserRelationalInterface $user
     * @return UserRelationalInterface
     * @throws AccessDeniedException
     */
    private function checkAuthanticity($user) {
        if($user === null) {
            throw NotFoundHttpException('User not found');
        }
        if (!$user instanceof UserRelationalInterface) {
            throw new AccessDeniedException('You are not sociable :D');
        }
        return $user;
    }
    
}
