<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('lastName', TextType::class)
            ->add('firstName', TextType::class)
            ->add('email', EmailType::class)
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Femme' => true,
                    'Homme' => false,
                ],
                'required' => true,
            ])
            ->add('birthDate', DateType::class, [
                'required' => true,
            ])
            ->add('department', IntegerType::class, [
                'required' => true
            ])
            ->add('city', TextType::class)
            ->add('role', ChoiceType::class , [
                'mapped' => false,
                'choices' => [
                    'Loueur' => true,
                    'Participant' => false,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
