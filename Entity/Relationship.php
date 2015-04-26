<?php

namespace Joubjoub\RelationshipBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Joubjoub\RelationshipBundle\Model\RelationshipInterface;

abstract class Relationship implements RelationshipInterface {

    
    /**
     * Unique id of the relationship
     * 
     * @var mixed 
     */
    protected $id;

    /**
     *
     * @var UserInterface 
     */
    protected $user;

    /**
     *
     * @var UserInterface 
     */
    protected $relatedUser;

    /**
     *
     * @var integer 
     */
    protected $status;
    
    /**
     *
     * @var string 
     */
    protected $type;

    /**
     *
     * @var \DateTime 
     */
    protected $created;

    /**
     *
     * @var \DateTime 
     */
    protected $updated;

    public function __construct(UserInterface $user, UserInterface $relatedUser) {
        $this->user = $user;
        $this->relatedUser = $relatedUser;
        $this->status = self::RELATION_ASK;
        $this->type = self::TYPE_DEFAULT;
    }

    /**
     * Get id
     *
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set user
     *
     * @return RelationshipInterface
     */
    public function setUser(UserInterface $user) {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return UserInterface
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set relatedUser
     *
     * @return RelationshipInterface
     */
    public function setRelatedUser(UserInterface $relatedUser) {
        $this->relatedUser = $relatedUser;
        return $this;
    }

    /**
     * Get relatedUser
     *
     * @return UserInterface
     */
    public function getRelatedUser() {
        return $this->relatedUser;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return RelationshipInterface
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus() {
        return $this->status;
    }
    
    /**
     * Set type
     *
     * @param string $type
     * @return RelationshipInterface
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return RelationshipInterface
     */
    public function setCreated(\DateTime $created) {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return RelationshipInterface
     */
    public function setUpdated(\DateTime $updated) {
        $this->updated = $updated;
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * @return array of available status
     */
    public static function getAvailableStatus() {
        return array(self::RELATION_ASK,self::RELATION_CONFIRMED, self::RELATION_DENY);
    }
    
    /**
     * @return array of available type
     */
    public static function getAvailableType() {
        return array(self::TYPE_DEFAULT, self::TYPE_FRIEND, self::TYPE_FAMILY, self::TYPE_COWORKER, self::TYPE_SEXEFRIEND);
    }
}
