<?php

// src/Form/DefaultFormType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\DefaultFormContent;

class DefaultFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->setAction('form')
                ->setMethod('POST')
                ->add('task', TextType::class, array(
                    'label' => 'Requis',
                    'attr' => ['class' => 'form-control', 'style' => 'height: 150px;'],
                    'label_attr' => ['style' => 'background-color: green;']
                ))
                ->add('blankTask', TextType::class, array(
                    'required' => false,
                    'label' => 'Non requis',
                    'attr' => ['class' => 'form-control']
                ))
                ->add('dueDate', DateType::class, array(
                    'label' => 'Choisir une date',
                    'attr' => ['type' => 'date']
                ))//, array('widget' => 'single_text')
                ->add('agreeTerms', CheckboxType::class, array(
                    'mapped' => false
                ))// mapped false means data isn't submitted
                ->add('valider', SubmitType::class, array(
                    'label' => 'Clique ici',
                    'attr' => ['class' => 'btn btn-primary']
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => DefaultFormContent::class,
        ));
    }

}
