<?php

namespace App\Core\User\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Core\User\Forms\SignInData;

/**
 * Description of SignInFormType
 *
 * @author Pierre
 */
class SignInFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // Text input doc: https://symfony.com/doc/current/reference/forms/types/text.html
        // Textarea input doc: https://symfony.com/doc/current/reference/forms/types/textarea.html
        $builder
//                ->setAction('#') // No action because this is a front side only form
//                ->setMethod('POST')
                ->add('username', TextType::class)
                ->add('password', PasswordType::class)
                ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => SignInData::class,
        ));
    }

}
