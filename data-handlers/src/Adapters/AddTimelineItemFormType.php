<?php

// src/Form/DefaultFormType.php

namespace App\Adapters;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Adapters\VisTimelineItem;

class AddTimelineItemFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->setAction('addTimelineItem')
                ->setMethod('POST')
//                ->setOnSubmit('return validateForm()')
                ->add('content', TextType::class, array(
                    'required' => true, //default value
                    'label' => 'Contenu',
                    'attr' => ['class' => 'form-control']
                ))//'label_attr' => ['style' => 'background-color: green;']      , 'style' => 'height: 150px;'
                ->add('start', TextType::class, array(
                    'required' => true, //default value
                    'label' => 'Date de début',
                    'attr' => ['class' => 'form-control', 
                        'placeholder' => 'Exemple: -348 ou aaaa/mm/jj',
                        'onmouseout' => 'validate()',
                        'onchange' => 'validate()']
                ))
                ->add('end', TextType::class, array(
                    'required' => false,
                    'label' => 'Date de fin',
                    'attr' => ['class' => 'form-control', 
                        'placeholder' => 'Exemple: -348 ou aaaa/mm/jj',
                        'onmouseout' => 'validate()',
                        'onchange' => 'validate()']
                ))
                ->add('valider', SubmitType::class, array(
                    'label' => 'Valider',
                    'disabled' => true,
                    'attr' => ['class' => 'btn btn-primary']
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => VisTimelineItem::class,
        ));
    }

}
