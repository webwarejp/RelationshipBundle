<?php

namespace Joubjoub\RelationshipBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Joubjoub\RelationshipBundle\Model\LinkableInterface;
use Joubjoub\RelationshipBundle\Model\LinkerManagerInterface;

class LinkerManager implements LinkerManagerInterface {

    protected $linkable = null;
    
    protected $em;
    protected $class;
    protected $repository;

    public function getClass() {
        return $this->class;
    }

    public function __construct(EntityManagerInterface $em, $class) {
        $this->em = $em;
        $this->class = $em->getClassMetadata($class)->name;
        $this->repository = $em->getRepository($class);
    }
    
    public function setLinkable($linkable) {
        $this->linkable = $linkable;
        return $this;
    }
    
    public function getLinkable() {
        return $this->linkable;
    }
    
     public function findLinkableById ($id) {
        $linkable = $this->repository->findOneById($id);
        return $this->setLinkable($linkable);
    }
    
    
    
}