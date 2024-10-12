<?php

namespace App\Form;

use App\Entity\Cinemas;
use App\Entity\Films;
use App\Entity\Reservations;
use App\Entity\Seance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombrePlaces')
            ->add('typePMR')
            ->add('prixTotal')
            ->add('cinemas', EntityType::class, [
                'class' => Cinemas::class,
                'choice_label' => 'id',
            ])
            ->add('films', EntityType::class, [
                'class' => Films::class,
                'choice_label' => 'id',
            ])
            ->add('seances', EntityType::class, [
                'class' => Seance::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
