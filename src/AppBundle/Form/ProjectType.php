<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProjectType
 * @package AppBundle\Form
 */
class ProjectType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('client')
            ->add('budget')
            ->add('startsAt', DateType::class,[
                'html5' => true,
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text'
            ])
            ->add('endsAt', DateType::class,[
                'html5' => true,
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Project'
        ]);
    }

}