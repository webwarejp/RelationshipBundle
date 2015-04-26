<?php
namespace Joubjoub\RelationshipBundle\Provider;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserProviderInterface {
    
    /**
     * Gets user
     *
     * @return UserInterface
     */
    public function getAuthanticatedUser();
    
}