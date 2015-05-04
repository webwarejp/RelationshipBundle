<?php
namespace Joubjoub\RelationshipBundle\Security;

use Joubjoub\RelationshipBundle\Model\UserRelationalInterface;

interface AuthorizerInterface {
    
    function canAddUser(UserRelationalInterface $user);
    
    
}