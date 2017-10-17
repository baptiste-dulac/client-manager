<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class InvoiceType
 * @package AppBundle\Form
 */
class InvoiceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client')
            ->add('code', TextType::class, [
                'required' => false
            ])
            ->add('paid')
            ->add('project')
            ->add('amount')
            ->add('details')
            ->add('createdAt', DateType::class,[
                'html5' => true,
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text'
            ])
            ->add('invoiceItems', CollectionType::class, [
                'entry_type' => InvoiceItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'by_reference' => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Invoice'
        ]);
    }

}