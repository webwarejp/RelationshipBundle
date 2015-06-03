<?php

namespace Joubjoub\RelationshipBundle\Model;

Interface LinkableInterface {

    /**
     * Gets the linker id
     * 
     * @return mixed
     */
    function getId();
    
    /**
     * get linker relation
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    function getRelationship();
    
    /**
     * get linked relation 
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    function getRelationshipWithMe();
    
    /**
     * get all relation between linked object
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    function getRelations();
    
    
}
