<?php

namespace Joubjoub\RelationshipBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Joubjoub\RelationshipBundle\Model\UserRelationalInterface;

abstract class User implements UserRelationalInterface {

    /**
     * @var mixed
     */
    protected $id;
    
    /**
     *
     * @var \Doctrine\Common\Collections\ArrayCollection of UserInterface
     */
    protected $user;
    
    /**
     *
     * @var \Doctrine\Common\Collections\ArrayCollection of UserInterface
     */
    protected $relatedUser;
    

    public function __construct() {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->relatedUser = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function getRelation() {
        return new \Doctrine\Common\Collections\ArrayCollection(array_merge($this->user->toArray(), $this->relatedUser->toArray()));
    }

    /**
     * 
     * @param UserInterface $user
     * @return type
     */
    public function hasRelationshipWith(UserInterface $user) {
        return $this->getRelation()->contains($user) ? true : false;
    }
}