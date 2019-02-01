<?php

namespace App\Form;

use App\Entity\Room;
use App\Entity\SlotAllowed;
use App\Entity\SlotTaken;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlotTakenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slot', EntityType::class, [
                'class' => SlotAllowed::class,
                'choice_label' => function(SlotAllowed $slotAllowed) {
                    return $slotAllowed->getStartTime()->format('H:i');
                }
            ])
            ->add('slotDate', DateType::class)
            ->add('room', EntityType::class , [
                'class' => Room::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SlotTaken::class,
        ]);
    }
}
