<?php
namespace Joubjoub\RelationshipBundle\Model;

use Joubjoub\RelationshipBundle\Model\LinkableInterface;

interface RelationshipInterface {
    
    const RELATION_ASK = 0;
    const RELATION_CONFIRMED = 1;
    const RELATION_DENY = 2;
    
    const TYPE_DEFAULT = 'relation';    
    const TYPE_FRIEND = 'friend';
    const TYPE_SPONSOR = 'sponsor';
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
    public function setLinker(LinkableInterface $linker);
    
    
    /**
     * Get user
     *
     * @return UserInterface
     */
    public function getLinker();
    
    
    /**
     * Set relatedUser
     *
     * @return RelationshipInterface
     */
    public function setLinked(LinkableInterface $linked);
   
    
    /**
     * Get relatedUser
     *
     * @return UserInterface
     */
    public function getLinked();
    
    
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
     * @param mixed $type
     * @return RelationshipInterface
     */
    public function setType($type);
    
    /**
     * Get type
     *
     * @return mixed 
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