<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use http\Env\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $user_role = $this->getUser()->getRoles();
        $em = $this->getDoctrine()->getManager();


        if (in_array('ROLE_TEACHER', $user_role))
        {
            $em = $this->getDoctrine()->getManager();
            $courses = $em->getRepository('AppBundle:Course')->findAll();
            $subjects = $em->getRepository('AppBundle:Subject')->findAll();
            return $this->render('default/index.html.twig', [
                'role' => 'ROLE_TEACHER',
                'users' => null,
                'courses' => $courses,
                'subjects' => $subjects,
                'current_user' => $this->getUser()
            ]);
        }

        if (in_array('ROLE_STUDENT', $user_role)) {
            $em = $this->getDoctrine()->getManager();
            return $this->render('default/index.html.twig', [
                'role' => 'ROLE_STUDENT',
                'users' => null,
                'courses' => null,
                'subjects' => null,
                'current_user' => $this->getUser()
            ]);
        }

        if (in_array('ROLE_ADMIN', $user_role)) {
            $em = $this->getDoctrine()->getManager();
            $users[] = $em->getRepository('AppBundle:User')
                ->findAllExceptCurrentUser($this->getUser());
            $courses = $em->getRepository('AppBundle:Course')->findAll();
            $subjects = $em->getRepository('AppBundle:Subject')->findAll();
            return $this->render('default/index.html.twig', [
                'role' => 'ROLE_ADMIN',
                'users' => $users,
                'courses' => $courses,
                'subjects' => $subjects,
                'current_user' => $this->getUser()
            ]);
        }

    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("disable/user/{id}", name="disable_user")
     */
    public function disableOrEnableUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy([
            'id'=> $id
        ]);
        if ($user->isEnabled()){
            $user->setEnabled(false);
        } else {
            $user->setEnabled(true);
        }

        $em->flush();
        return $this->redirectToRoute('homepage');

    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("disable/course/{id}", name="disable_course")
     */
    public function disableOrEnableCourse($id)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('AppBundle:Course')->findOneBy([
            'id'=> $id
        ]);
        if ($course->getisEnabled()){
            $course->setIsEnabled(false);
        } else {
            $course->setIsEnabled(true);
        }

        $em->flush();
        return $this->redirectToRoute('homepage');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("disable/subject/{id}", name="disable_subject")
     */
    public function disableOrEnableSubject($id)
    {
        $em = $this->getDoctrine()->getManager();
        $subject = $em->getRepository('AppBundle:Subject')->findOneBy([
            'id'=> $id
        ]);
        if ($subject->getisEnabled()) {
            $subject->setIsEnabled(false);
        } else {
            $subject->setIsEnabled(true);
        }
        $em->flush();
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("adopt", name="adoptCourse")
     */
    public function studentAdoptCourse()
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('AppBundle:Course')
            ->findAll();
        return $this->render(':default:adopt.html.twig', [
            'courses' => $courses
        ]);
    }

    /**
     * @Route("add/adopted/course{id}", name="add_adopted_course")
     */
    public function add_adopted_course($id)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('AppBundle:Course')->findOneBy([
            'id' => $id
        ]);
        $this->getUser()->setCourse($course);
        $em->flush();
        return $this->redirectToRoute('homepage');
    }


}
