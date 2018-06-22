<?php
/**
 * Created by PhpStorm.
 * User: coeus
 * Date: 6/22/18
 * Time: 11:51 AM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Subject;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $this->addUser($manager);
//        $this->addSubjects($manager);
    }

    /**
     * @param ObjectManager $manager
     */
    private function addUser(ObjectManager $manager)
    {
        $roles = ['ROLE_STUDENT', 'ROLE_TEACHER', 'ROLE_ADMIN'];
        // create 20 users
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername('user#'.rand(1000,9999));
            $user->setPlainPassword('password');
            $user->setEmail($user->getUsername().'@email.com');
            $user->setEnabled(true);
            $user->addRole($roles[rand(0,2)]);
            $manager->persist($user);
        }
        $manager->flush();

    }

//    /**
//     * @param ObjectManager $manager
//     */
//    private function addSubjects(ObjectManager $manager)
//    {
//        for ($i = 0; $i < 30; $i++) {
//            $subject = new Subject();
//            $subject->setName('subject#'.$i+19);
//            $subject->setDescription('description of subject'.$subject->getName());
//            $subject->setIsEnabled(true);
//            $subject->setUser(4);
//            $manager->persist($subject);
//        }
//        $manager->flush();
//    }
//
//    /**
//     * @param ObjectManager $manager
//     */
//    private function addCourses(ObjectManager $manager)
//    {
//
//    }

}