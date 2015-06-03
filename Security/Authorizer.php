<?php

namespace Joubjoub\RelationshipBundle\Security;

use Joubjoub\RelationshipBundle\Manager\RelationshipManager;
use Joubjoub\RelationshipBundle\Security\AuthorizerInterface;
use Joubjoub\RelationshipBundle\Model\LinkableInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Authorizer implements AuthorizerInterface {

    protected $relationshipManager;
    
    public function __construct(RelationshipManager $relationshipManager) {
        $this->relationshipManager = $relationshipManager;
    }
    
    public function checkAuthanticity ($linkable) {
        if($linkable === null) {
            throw new NotFoundHttpException('Linker not found');
        }
        if (!$linkable instanceof LinkableInterface) {
            throw new \UnexpectedValueException('Not linkable');
        }
        return true;
    }
    
    public function canLink(LinkableInterface $linker, LinkableInterface $linked, $type) {
        $this->checkAuthanticity($linker);
        $this->checkAuthanticity($linked);
        
        if ($this->IsSame($linker, $linked)) {
           throw new \Exception('Linker and linked cant be equals');
        }
        if($this->existRelationshipByType($linker, $linked, $type)) {
            throw new \Exception('A link already exist between this 2 linkable');
        }
        return true;
    }
    
    /**
     * 
     * @param LinkableInterface $linker
     * @param LinkableInterface $linked
     * @return Boolean
     */
    protected function IsSame(LinkableInterface $linker, LinkableInterface $linked) {
        return $linker === $linked ? true : false;
    }

    /**
     * 
     * @param LinkableInterface $linker
     * @param LinkableInterface $linked
     * @return Boolean
     */
    protected function existRelationship(LinkableInterface $linker, LinkableInterface $linked) {
        $relationship = $this->relationshipManager->findOneBetweenLinkable($linker, $linked);
        return !empty($relationship) ? true : false;
    }
    
    /**
     * 
     * @param LinkableInterface $linker
     * @param LinkableInterface $linked
     * @param type $type
     * @return type
     */
    protected function existRelationshipByType(LinkableInterface $linker, LinkableInterface $linked, $type) {
        $relationship = $this->relationshipManager->findOneBetweenLinkableByType($linker, $linked, $type);
        return !empty($relationship) ? true : false;
    }
    
}
