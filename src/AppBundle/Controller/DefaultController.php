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
                'role' => implode(' ', $user_role),
                'users' => null,
                'courses' => $courses,
                'subjects' => $subjects
            ]);
        }

        if (in_array('ROLE_STUDENT', $user_role)) {
            $em = $this->getDoctrine()->getManager();
            $subjects = $em->getRepository('AppBundle:Subject')->findAll();
            return $this->render('default/index.html.twig', [
                'role' => implode(' ', $user_role),
                'users' => null,
                'courses' => null,
                'subjects' => $subjects
            ]);
        }

        if (in_array('ROLE_ADMIN', $user_role)) {
            $em = $this->getDoctrine()->getManager();
            $users[] = $em->getRepository('AppBundle:User')->findAll();
            $courses = $em->getRepository('AppBundle:Course')->findAll();
            $subjects = $em->getRepository('AppBundle:Subject')->findAll();
            return $this->render('default/index.html.twig', [
                'role' => implode(' ', $user_role),
                'users' => $users,
                'courses' => $courses,
                'subjects' => $subjects
            ]);
        }

//
//        dump($users);
//        die();

//        return $this->render('default/index.html.twig', [
//            'role' => implode(' ', $user_role),
//            'users' => $users
//        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("disable/user/{id}", name="disable_user")
     */
    public function disableUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy([
            'id'=> $id
        ]);
        $user->setEnabled(false);
        $em->flush();
        return $this->redirectToRoute('homepage');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("disable/course/{id}", name="disable_course")
     */
    public function disableCourse($id)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('AppBundle:Course')->findOneBy([
            'id'=> $id
        ]);
        $course->setIsEnabled(false);
        $em->flush();
        return $this->redirectToRoute('homepage');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("disable/subject/{id}", name="disable_subject")
     */
    public function disableSubject($id)
    {
        $em = $this->getDoctrine()->getManager();
        $subject = $em->getRepository('AppBundle:Subject')->findOneBy([
            'id'=> $id
        ]);
        $subject->setIsEnabled(false);
        $em->flush();
        return $this->redirectToRoute('homepage');
    }

}
