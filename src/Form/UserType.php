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
            ->add('lastName', TextType::class, ['required' => false])
            ->add('firstName', TextType::class, ['required' => false])
            ->add('email', EmailType::class, ['required' => false])
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Femme' => true,
                    'Homme' => false,
                ],
                'required' => false,
            ])
            ->add('birthDate', DateType::class, [
                'required' => false,
            ])
            ->add('department', IntegerType::class, [
                'required' => false
            ])
            ->add('city', TextType::class , ['required' => false])
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
