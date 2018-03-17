<?php

namespace App\Form\Admin;

use App\Entity\InvoiceItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class InvoiceItemType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('details', TextareaType::class,  [
                'required' => true
            ])
            ->add('amount', NumberType::class,  [
                'scale' => 2,
                'required' => true
            ])
            ->add('quantity', NumberType::class,  [
                'scale' => 1,
                'required' => true
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InvoiceItem::class
        ]);
    }

}