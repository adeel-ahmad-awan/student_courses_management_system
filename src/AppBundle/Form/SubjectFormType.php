<?php

namespace AppBundle\Form;

use AppBundle\Repository\CourseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('course_subjects')
//            ->add('course_subjects', EntityType::class, [
//                'class' => 'AppBundle\Entity\Course',
//                'query_builder' => function(CourseRepository $repo) {
//                    return $repo->findAllEnabledCourses();
//                }
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Subject'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_subject_form_type';
    }
}
