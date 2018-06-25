<?php
/**
 * Created by PhpStorm.
 * User: coeus
 * Date: 6/25/18
 * Time: 11:17 AM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return User[]
     */
    public function findAllExceptCurrentUser(User $user)
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.id != :currentUser')
            ->setParameter('currentUser', $user->getId())
            ->getQuery()
            ->execute();
    }

}