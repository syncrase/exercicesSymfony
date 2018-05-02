<?php

namespace App\Core\User\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Core\User\Forms\SignUpData;

/**
 * Description of TimelineControlPanelFormType
 *
 * @author Pierre
 */
class SignUpFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // Text input doc: https://symfony.com/doc/current/reference/forms/types/text.html
        // Textarea input doc: https://symfony.com/doc/current/reference/forms/types/textarea.html
        $builder
//                ->setAction('#')
//                ->setMethod('POST')
                ->add('username', TextType::class)
                ->add('password', PasswordType::class)
                ->add('email', EmailType::class)
                ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => SignUpData::class,
        ));
    }

}
