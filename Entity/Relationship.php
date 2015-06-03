<?php

namespace Joubjoub\RelationshipBundle\Entity;

use Joubjoub\RelationshipBundle\Model\LinkableInterface;
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
     * @var LinkableInterface 
     */
    protected $linker;

    /**
     *
     * @var LinkableInterface 
     */
    protected $linked;

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

    public function __construct(LinkableInterface $linker, LinkableInterface $linked) {
        $this->linker = $linker;
        $this->linked = $linked;
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
    public function setLinker(LinkableInterface $linker) {
        $this->linker = $linker;
        return $this;
    }

    /**
     * Get user
     *
     * @return UserInterface
     */
    public function getLinker() {
        return $this->linker;
    }

    /**
     * Set relatedUser
     *
     * @return LinkableInterface
     */
    public function setLinked(LinkableInterface $linked) {
        $this->linked = $linked;
        return $this;
    }

    /**
     * Get relatedUser
     *
     * @return LinkableInterface
     */
    public function getLinked() {
        return $this->linked;
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
     * @param mixed $type
     * @return RelationshipInterface
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return mixed 
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
        return array(self::RELATION_ASK, self::RELATION_CONFIRMED, self::RELATION_DENY);
    }
    
    /**
     * @return array of available type
     */
    public static function getAvailableType() {
        return array(self::TYPE_DEFAULT, self::TYPE_FRIEND, self::TYPE_FAMILY, self::TYPE_COWORKER, self::TYPE_SEXEFRIEND);
    }
}
