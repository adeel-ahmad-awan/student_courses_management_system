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

class CourseRepository extends EntityRepository
{
    public function findAllEnabledCourses()
    {
        return $this->createQueryBuilder('course')
            ->andWhere('course.is_enabled = :enabled')
            ->setParameter('enabled', true)
            ->getQuery()
            ->execute();
    }

}