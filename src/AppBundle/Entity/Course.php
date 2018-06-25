<?php
/**
 * Created by PhpStorm.
 * User: coeus
 * Date: 6/20/18
 * Time: 1:22 PM
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourseRepository")
 * @ORM\Table(name="course")
 */
class Course
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_enabled;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Subject", mappedBy="course_subjects")
     */
    private $subject_courses;

    public function __construct()
    {
        $this->is_enabled = true;
        $this->subject_courses = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getisEnabled()
    {
        return $this->is_enabled;
    }

    /**
     * @param mixed $is_enabled
     */
    public function setIsEnabled($is_enabled)
    {
        $this->is_enabled = $is_enabled;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return ArrayCollection|Subject[]
     */
    public function getSubjectCourses()
    {
        return $this->subject_courses;
    }

    /**
     * @param $subject_courses
     */
    public function setSubjectCourses($subject_courses)
    {
        foreach ( $subject_courses as $subject){
            if (!($this->subject_courses->contains($subject))) {
                $this->subject_courses[] = $subject;
                $subject->addCourse($this);
            }
        }
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->getName();
    }
}