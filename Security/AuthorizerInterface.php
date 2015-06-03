<?php
namespace Joubjoub\RelationshipBundle\Security;

use Joubjoub\RelationshipBundle\Model\LinkableInterface;

interface AuthorizerInterface {
    
    function checkAuthanticity($linkable);
    
    function canLink(LinkableInterface $linker, LinkableInterface $linked, $type);
    
}