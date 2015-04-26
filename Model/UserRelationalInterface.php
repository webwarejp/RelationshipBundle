<?php

namespace Joubjoub\RelationshipBundle\Model;

Interface UserRelationalInterface {

    /**
     * Gets the user id
     * 
     * @return mixed
     */
    function getId();
    
    /**
     * get relation between users
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    function getRelationship();
    
    /**
     * say if there is a relation between users
     * 
     * @return Boolean
     */
//    function hasRelationship();
    
    
}
