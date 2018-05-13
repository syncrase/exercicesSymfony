<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username')
//            ->add('email')
//            ->add('password')
            ->add('_password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
//            ->add('createdAt')
//            ->add('description')
//            ->add('imageFilename')
//            ->add('heartCount')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
//        If you're building a login form that will be used with Symfony's native form_login system,
// override getBlockPrefix() and make it return an empty string.
// This will put the POST data in the proper place so the form_login system can find it.
//        return parent::getBlockPrefix();
        return '';
    }

//This is a rare time when I won't bother binding my form to a class.
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class' => User::class,
//        ]);
//    }
}
