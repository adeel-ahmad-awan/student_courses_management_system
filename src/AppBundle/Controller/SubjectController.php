<?php
/**
 * Created by PhpStorm.
 * User: coeus
 * Date: 6/21/18
 * Time: 12:35 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Subject;
use AppBundle\Form\SubjectFormType;
use AppBundle\Repository\CourseRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubjectController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("subject/new", name="new_subject_path")
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Course')->findAllEnabledCourses();

        $form = $this->createForm(SubjectFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $subject = $form->getData();
            $subject->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();

//            redirect to show page
            return $this->redirectToRoute('show_subject_path', [
                'subjectName' => $subject->getName()
            ]);
        }

        return $this->render('subject/new.html.twig', [
            'subjectForm' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Subject $subject
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("subject/{id}/edit", name="edit_subject_path")
     */
    public function editAction(Request $request, Subject $subject)
    {
        if ($subject->getisEnabled() == false) {
            throw $this->createNotFoundException('Course "'. $subject->getName() .'" is disabled by admin');
        }

        $form = $this->createForm(SubjectFormType::class, $subject);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $subject = $form->getData();
            $subject->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();

//            redirect to show page
            return $this->redirectToRoute('show_subject_path', [
                'subjectName' => $subject->getName()
            ]);
        }

        return $this->render('subject/new.html.twig', [
            'subjectForm' => $form->createView()
        ]);
    }


    /**
     * @return Response
     * @Route("/subjects", name="list_subject_path")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $subjects = $em->getRepository('AppBundle:Subject')->findAll();
        return $this->render('subject/list.html.twig', [
            'subjects' => $subjects
        ]);
    }

    /**
     * @param $subjectName
     * @return Response
     * @Route("subject/{subjectName}", name="show_subject_path")
     */
    public function showAction($subjectName) {
        $em = $this->getDoctrine()->getManager();
        $subject = $em->getRepository('AppBundle:Subject')
            ->findOneBy(['name' => $subjectName ]);

        if (!$subject) {
            throw $this->createNotFoundException('no subject available with name '. $subjectName);
        } elseif ($subject->getisEnabled() == false) {
            throw $this->createNotFoundException('Course "'. $subject->getName() .'" is disabled by admin');
        }


        return $this->render('subject/show.html.twig', [
            'subject' => $subject
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("subject/delete/{id}", name="delete_subject_path")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $subject = $em->getRepository('AppBundle:Subject')
            ->findOneBy([
                'id' => $id
            ]);

        if (!$subject) {
            throw $this->createNotFoundException('no subject found with id '. $id);
        } elseif ($subject->getisEnabled() == false) {
            throw $this->createNotFoundException('Course "'. $subject->getName() .'" is disabled by admin');
        }


        $em->remove($subject);
        $em->flush();

        $subjects = $em->getRepository('AppBundle:Subject')->findAll();

        return $this->redirectToRoute('list_subject_path', [
            'subjects' => $subjects
        ]);
    }


}