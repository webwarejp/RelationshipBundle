<?php

namespace Joubjoub\RelationshipBundle\Entity;

use Joubjoub\RelationshipBundle\Model\LinkableInterface;

abstract class Linker implements LinkableInterface {

    /**
     * @var mixed
     */
    protected $id;
    
    /**
     *
     * @var \Doctrine\Common\Collections\ArrayCollection of UserInterface
     */
    protected $relationship;
    
    /**
     *
     * @var \Doctrine\Common\Collections\ArrayCollection of UserInterface
     */
    protected $relationshipWithMe;
    

    public function __construct() {
        $this->relationship = new \Doctrine\Common\Collections\ArrayCollection();
        $this->relationshipWithMe = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * get id
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getRelationshipWithMe()
    {
        return $this->relationshipWithMe;
    }
    
    /**
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRelations() {
        return new \Doctrine\Common\Collections\ArrayCollection(array_merge($this->relationship->toArray(), $this->relationshipWithMe->toArray()));
    }

   
}