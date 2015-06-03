<?php

namespace Joubjoub\RelationshipBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Joubjoub\RelationshipBundle\Model\RelationshipInterface;

class RelationshipEvent extends Event {
    
    protected $relationship = null;
    
    public function __construct(RelationshipInterface $relationship) {
        $this->relationship = $relationship;
    }
    
    public function getRelationship() {
        return $this->relationship;
    }
    
    public function setRelationship(RelationshipInterface $relationship) {
        $this->relationship = $relationship;
        return $this;
    }
    
}