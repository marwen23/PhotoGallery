<?php
/**
 * Created by PhpStorm.
 * User: marwen
 * Date: 10/14/2017
 * Time: 2:38 PM
 */

namespace AppBundle\Form;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $builder->add('first_name', null, array('label' => 'First Name','attr' => array('class' => 'form-control' ) ))
        ->add('last_name', null, array('label' => 'Last Name','attr' => array('class' => 'form-control' ) ))
        ->add('username', null, array('label' => 'Username','attr' => array('class' => 'form-control' ) ))
        ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'Email', 'translation_domain' => 'FOSUserBundle','attr' => array('class' => 'form-control' )))
        ->add('username', null, array('label' => 'Username', 'translation_domain' => 'FOSUserBundle','attr' => array('class' => 'form-control' )))
        ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
            'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'Password','attr' => array('class' => 'form-control' )),
            'second_options' => array('label' => 'Confirm Password','attr' => array('class' => 'form-control' )),
            'invalid_message' => 'fos_user.password.mismatch',
        ))
            ->add('roles', ChoiceType::class, array('attr' => array('class' => 'form-control' ),
                'multiple' => true,
                'choices' => array(
                    'Administrator' => "ROLE_ADMIN",
                    'Simple User' => "ROLE_User"

                )))
    ;
    }

    public function getParent()

    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()

    {
        return 'app_user_registration';
    }

    public function getName()

    {
        return $this->getBlockPrefix();
    }

}