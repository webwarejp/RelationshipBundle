<?php

namespace Joubjoub\RelationshipBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface RelationshipInterface {
    
    const RELATION_ASK = 0;
    const RELATION_CONFIRMED = 1;
    const RELATION_DENY = 2;
    
    const TYPE_DEFAULT= 'relation';    
    const TYPE_FRIEND = 'friend';
    const TYPE_FAMILY = 'family';
    const TYPE_COWORKER = 'coworker';
    const TYPE_SEXEFRIEND = 'sexefriend'; /* bad boy ;)*/
    /*...*/
    
    /**
     * Gets the relationship id
     * 
     * @return mixed
     */
    function getId();
    
    
    /**
     * Set user
     *
     * @return RelationshipInterface
     */
    public function setUser(UserInterface $user);
    
    
    /**
     * Get user
     *
     * @return UserInterface
     */
    public function getUser();
    
    
    /**
     * Set relatedUser
     *
     * @return RelationshipInterface
     */
    public function setRelatedUser(UserInterface $relatedUser);
   
    
    /**
     * Get relatedUser
     *
     * @return UserInterface
     */
    public function getRelatedUser();
    
    
    /**
     * Set status
     *
     * @param integer $status
     * @return RelationshipInterface
     */
    public function setStatus($status);

    
    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus();
    
    /**
     * Set type
     *
     * @param string $type
     * @return RelationshipInterface
     */
    public function setType($type);
    
    /**
     * Get type
     *
     * @return string 
     */
    public function getType();
    
    
    /**
     * Gets the relationship creation date
     * 
     * @return \DateTime
     */
    function getCreated();
    
    
    /**
     * Gets the relation creation date
     * 
     * @param \DateTime
     * @return RelationshipInterface
     */
    function setCreated(\DateTime $created);
    
    
    /**
     * Gets the relationship updated date
     * 
     * @return \DateTime
     */
    function getUpdated();
    
    
    /**
     * Gets the last update update date
     * 
     * @param \DateTime
     * @return RelationshipInterface
     */
    function setUpdated(\DateTime $created);
    
    
    /**
     * return the relation status list
     * @return array
     */
    static function getAvailableStatus();
    
    
    /**
     * return the relation type list
     * @return array
     */
    static function getAvailableType();
}