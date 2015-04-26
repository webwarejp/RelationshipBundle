<?php

namespace Joubjoub\RelationshipBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Joubjoub\RelationshipBundle\Manager\BaseManager;
use Joubjoub\RelationshipBundle\Model\UserRelationalInterface;
use Joubjoub\RelationshipBundle\Model\RelationshipInterface;

class RelationshipManager extends BaseManager {

    public function __construct(EntityManagerInterface $em, $class) {
        parent::__construct($em, $class);
    }

    public function create(UserRelationalInterface $userRelational, UserRelationalInterface $userAdded) {
        $rsClass = $this->getClass();
        $relationship = new $rsClass($userRelational, $userAdded);
        $relationship->setStatus(RelationshipInterface::RELATION_ASK);
        $relationship->setType(RelationshipInterface::TYPE_DEFAULT);
        $this->em->persist($relationship);
        $this->em->flush();
    }

    public function remove(RelationshipInterface $relationship) {
        $this->em->remove($relationship);
        $this->em->flush();
    }

    public function findOneById($id) {
        return $this->repository->findOneById($id);
    }

    public function findOneRelationshipBetweenUsers(UserRelationalInterface $user, UserRelationalInterface $user2) {
        $qb = $this->repository->createQueryBuilder('rs')
                ->join('rs.relatedUser', 'u')
                ->where('rs.user = :user AND u = :user2 ')
                ->orWhere('rs.user = :user2 AND u= :user ');
        $qb->setParameter("user", $user);
        $qb->setParameter("user2", $user2);
        $resultat = $qb->getQuery()->getResult();
        return $resultat;
    }

    public function findAllRelationshipByUser(UserRelationalInterface $user) {
        $qb = $this->repository->createQueryBuilder('rs')
                ->join('rs.relatedUser', 'ru')
                ->join('rs.user', 'u')
                ->where('rs.user = :user')
                ->orWhere('rs.relatedUser = :user ');
        
        $qb->setParameter("user", $user);
        $result = $qb->getQuery()->getResult();
        return $result;
    }
    
    public function findAllRelationshipByUserAndStatus(UserRelationalInterface $user, $status) {
        $qb = $this->repository->createQueryBuilder('rs')
                ->join('rs.relatedUser', 'ru')
                ->join('rs.user', 'u')
                ->where('rs.user = :user')
                ->orWhere('rs.relatedUser = :user ')
                ->andWhere('rs.status = :status');
        $qb->setParameter("status", $status);
        $qb->setParameter("user", $user);
        $result = $qb->getQuery()->getResult();
        return $result;
    }

    public function findAllRelationshipByUserAndStatusAndType(UserRelationalInterface $user, $status, $type) {
        $qb = $this->repository->createQueryBuilder('rs')
                ->join('rs.relatedUser', 'ru')
                ->join('rs.user', 'u')
                ->where('rs.user = :user')
                ->orWhere('rs.relatedUser = :user')
                ->andWhere('rs.type = :type')
                ->andWhere('rs.status = :status');
        $qb->setParameter("type", $type);
        $qb->setParameter("status", $status);
        $qb->setParameter("user", $user);

        $result = $qb->getQuery()->getResult();
        return $result;
    }

    public function IsStatusAvailable() {
        
    }

    public function IsTypeAvailable() {
        
    }

    
//    public function update(UserRelationalInterface $userRelational, UserRelationalInterface $userRemove) {
//        $relationship = $this->findOneRelationship($userRelational, $userRemove);
//         $relationship->setStatus(RelationshipInterface::RELATION_CANCELED);
//        $this->em->persist($relationship);
//        $this->em->flush();
//    }
    
}
