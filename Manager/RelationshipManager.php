<?php

namespace Joubjoub\RelationshipBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Joubjoub\RelationshipBundle\Model\LinkableInterface;
use Joubjoub\RelationshipBundle\Model\RelationshipInterface;

class RelationshipManager {

    protected $em;
    protected $class;
    protected $repository;

    public function getClass() {
        return $this->class;
    }

    public function __construct(EntityManagerInterface $em, $class) {
        $this->em = $em;
        $this->class = $em->getClassMetadata($class)->name;
        $this->repository = $em->getRepository($class);
    }

    public function create(LinkableInterface $linker, LinkableInterface $linked, $type = RelationshipInterface::TYPE_DEFAULT, $status = RelationshipInterface::RELATION_ASK) {
        $rsClass = $this->getClass();
        $relationship = new $rsClass($linker, $linked);
        $relationship->setStatus($status);
        $relationship->setType($type);
        $this->save($relationship);
        return $relationship;
    }

    public function remove(RelationshipInterface $relationship) {
        $this->em->remove($relationship);
        $this->em->flush();
    }
    
    public function save(RelationshipInterface $relation, $flush = true) {
        $this->em->persist($relation);
        if($flush) {
            $this->em->flush();
        }
    }

    
    public function findOneById($id) {
        return $this->repository->findOneBy(array('id'=>$id));
    }
    
    public function findOneBetweenLinkable(LinkableInterface $linker, LinkableInterface $linked) {
        $qb = $this->repository->createQueryBuilder('rs')
                ->join('rs.linked', 'u')
                ->where('rs.linker = :linkable AND u = :linkable2 ')
                ->orWhere('rs.linker = :linkable2 AND u= :linkable ');
        $qb->setParameter("linkable", $linker);
        $qb->setParameter("linkable2", $linked);
        $resultat = $qb->getQuery()->getResult();
        return $resultat;
    }
    
    public function findOneBetweenLinkableByType(LinkableInterface $linker, LinkableInterface $linked, $type) {
        $qb = $this->repository->createQueryBuilder('rs')
                ->join('rs.linked', 'u')
                ->where('rs.linker = :linkable AND u = :linkable2 ')
                ->orWhere('rs.linker = :linkable2 AND u= :linkable ')
                ->andWhere('rs.type = :type');
        $qb->setParameter("linkable", $linker);
        $qb->setParameter("linkable2", $linked);
        $qb->setParameter("type", $type);
        $resultat = $qb->getQuery()->getResult();
        return $resultat;
    }
    
    public function findRelationshipsByLinkable(LinkableInterface $linkable) {
        $qb = $this->initQb();
        $qb->setParameter("linkable", $linkable);
        $result = $qb->getQuery()->getResult();
        return $result;
    }
    
    public function findRelationshipsByLinkableAndStatus(LinkableInterface $linkable, $status) {
        $qb = $this->initQb()->andWhere('rs.status = :status');
        $qb->setParameter("status", $status);
        $qb->setParameter("linkable", $linkable);
        $result = $qb->getQuery()->getResult();
        return $result;
     }
    
    public function findRelationshipsByLinkableAndStatusAndType(LinkableInterface $linkable, $status, $type) {
        $qb = $this->initQb()
                ->andWhere('rs.status = :status')
                ->andWhere('rs.type = :type');
        $qb->setParameter("type", $type);
        $qb->setParameter("status", $status);
        $qb->setParameter("linkable", $linkable);

        $result = $qb->getQuery()->getResult();
        return $result;
    }
    
    
    private function initQb() {
         $qb = $this->repository->createQueryBuilder('rs')
                ->join('rs.linked', 'ru')
                ->join('rs.linker', 'u')
                ->where('rs.linker = :linkable')
                ->orWhere('rs.linked = :linkable');
         return $qb;
    } 
}
