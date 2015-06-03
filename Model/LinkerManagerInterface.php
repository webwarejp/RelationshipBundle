<?php

namespace Joubjoub\RelationshipBundle\Model;

Interface LinkerManagerInterface {

    /**
     * return instance of Joubjoub\RelationshipBundle\Model\LinkableInterace
     * 
     * @return Joubjoub\RelationshipBundle\Model\LinkableInterace
     */
    function getLinkable();
}
