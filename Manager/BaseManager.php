<?php

namespace Joubjoub\RelationshipBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of BaseManager
 *
 */
abstract class BaseManager {

    protected $em;
    
    protected $class;
    
    protected $repository;
    
    public function getClass() {
        return $this->class;
    }

    public function __construct(EntityManagerInterface $em, $class){
        $this->em = $em;
        $this->class = $em->getClassMetadata($class)->name;
        $this->repository = $em->getRepository($class);
    }
    
}
