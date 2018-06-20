<?php
/**
 * Created by PhpStorm.
 * User: coeus
 * Date: 6/20/18
 * Time: 3:11 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Course;
use AppBundle\Form\CourseFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    /**
     * @Route("course/new", name="new_course_path")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(CourseFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $course = $form->getData();
            $course->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush();
            //redirect to show page
            return $this->redirectToRoute('show_course_path', [
               'courseName' => $course->getName()
            ]);
        }

        return $this->render('course/new.html.twig', [
            'courseForm' => $form->createView()
        ]);
    }

    /**
     * @Route("course/{id}/edit", name="edit_course_path")
     */
    public function editAction(Request $request, Course $course)
    {
        $form = $this->createForm(CourseFormType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $course = $form->getData();
            $course->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush();
            //redirect to show page
            return $this->redirectToRoute('show_course_path', [
                'courseName' => $course->getName()
            ]);
        }

        return $this->render('course/edit.html.twig', [
            'courseForm' => $form->createView()
        ]);
    }

    /**
     * @Route("courses", name="list_course_path")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('AppBundle:Course')
            ->findAll();
        return $this->render('course/list.html.twig', [
            'courses' => $courses
        ]);
    }


    /**
     * @Route("course/delete/{id}", name="delete_course_path")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('AppBundle:Course')
            ->findOneBy(['id' => $id]);
        if (!$course) {
            throw $this->createNotFoundException('no course with id '. $id);
        }

        $em->remove($course);
        $em->flush();

        $courses = $em->getRepository('AppBundle:Course')->findAll();

        return $this->redirectToRoute('list_course_path', [
            'courses' => $courses
        ]);
    }


    /**
     * @Route("course/{courseName}", name="show_course_path")
     */
    public function showAction($courseName)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('AppBundle:Course')
            ->findOneBy(['name' => $courseName]);

        if (!$course) {
            throw $this->createNotFoundException('no course with name '. $courseName);
        }

        return $this->render('course/show.html.twig', [
            'course' => $course
        ]);
    }


}