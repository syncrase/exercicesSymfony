<?php

namespace App\Core\VisJS\Timeline\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Core\VisJS\Timeline\Forms\TimelineControlPanelFormType;

/**
 * Description of TimelineControlPanelFormType
 *
 * @author Pierre
 */
class TimelineControlPanelFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // Text input doc: https://symfony.com/doc/current/reference/forms/types/text.html
        // Textarea input doc: https://symfony.com/doc/current/reference/forms/types/textarea.html
        $builder
//                ->setAction('#') // No action because this is a front side only form
                ->setMethod('POST')
                ->add('content', TextType::class)
                ->add('start', TextType::class, array(
//                    'attr' => ['class' => 'form-control',
//                        'onmouseout' => 'validate()',
//                        'onchange' => 'validate()']
                ))
                ->add('end', TextType::class, array(
//                    'attr' => ['class' => 'form-control',
//                        'onmouseout' => 'validate()',
//                        'onchange' => 'validate()']
                ))
                ->add('notes', TextareaType::class)
                ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => TimelineControlPanelFormType::class,
        ));
    }

}
