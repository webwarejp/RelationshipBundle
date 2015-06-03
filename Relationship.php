<?php

namespace Joubjoub\RelationshipBundle;

use Joubjoub\RelationshipBundle\Manager\RelationshipManager;

use Joubjoub\RelationshipBundle\Model\LinkableInterface;
use Joubjoub\RelationshipBundle\Model\RelationshipInterface;
use Joubjoub\RelationshipBundle\Security\AuthorizerInterface;
use Joubjoub\RelationshipBundle\Event\RelationshipEvent;

class Relationship 
{
    protected $linker = null;
    protected $linked = null;
    
    protected $relationshipManager;
    protected $authorizer;
    protected $eventDispatcher;
    
    public function __construct(RelationshipManager $relationshipManager,  AuthorizerInterface $authorizer, $eventDispatcher) {
         $this->relationshipManager = $relationshipManager;
         $this->authorizer = $authorizer;
         $this->eventDispatcher = $eventDispatcher;
    }
    
    
    public function create(LinkableInterface $linker, LinkableInterface $linked, $type = RelationshipInterface::TYPE_DEFAULT) {
        if($this->authorizer->canLink($linker, $linked, $type)) {
            $this->setLinker($linker);
            $this->setLinked($linked);
            $relationship = $this->relationshipManager->create($linker, $linked, $type);
            
            $event = new RelationshipEvent($relationship);
            $this->eventDispatcher->dispatch(RelationshipEvents::NEW_RELATIONSHIP, $event);
        }
    }
    
    public function remove(RelationshipInterface $relationship) {
        $this->relationshipManager->remove($relationship);
    }
    
    public function getRelationship($id) {
        return $this->relationshipManager->findOneById($id);
    }
    
    public function getRelationships() {
        return $this->relationshipManager->findRelationshipsByLinkable($this->getLinker());
    }
    
    public function getRelationshipsByStatusAndType($type = RelationshipInterface::TYPE_DEFAULT, $status = RelationshipInterface::RELATION_ASK) {
        return $this->relationshipManager->findRelationshipsByLinkableAndStatusAndType($this->getLinker(), $status, $type);
    }
    
    
    public function getRelationshipManager() {
       return $this->relationshipManager;
    }
    
    
    public function getLinker() {
        if(!$this->authorizer->checkAuthanticity($this->linker)) {
            Throw new \Exception('linker not found');
        }
        return $this->linker;
    }
    
    public function setLinker(LinkableInterface $linker) {
        $this->linker = $linker;
        return $this;
    }
    
    public function getLinked() {
        if(!$this->authorizer->checkAuthanticity($this->linked)) {
            Throw new \Exception('linked not found');
        }
        return $this->linked;
    }
    public function setLinked(LinkableInterface $linked) {
         $this->linked = $linked;
        return $this;
    }
}