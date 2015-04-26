<?php

namespace Joubjoub\RelationshipBundle\Provider;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Joubjoub\RelationshipBundle\Provider\UserProviderInterface;

class UserProvider implements UserProviderInterface {

    /**
     * The security context
     *
     * @var SecurityContextInterface
     */
    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext) {
        $this->securityContext = $securityContext;
    }

    /**
     * Gets the current authenticated user
     *
     * @return UserInterface
     */
    public function getAuthanticatedUser() {
        $user = $this->securityContext->getToken()->getUser();
        if (!$user instanceof UserInterface) {
            throw new AccessDeniedException('Have to be logged');
        }
        return $user;
    }

}
