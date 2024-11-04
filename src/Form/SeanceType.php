<?php

namespace App\Form;

use App\Entity\Films;
use App\Entity\Seance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeanceType extends AbstractType
{
    public function buildForm (FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add ('HeureDebut', null, [
                'widget' => 'single_text',
            ])
            ->add ('films', EntityType::class, [
                'class' => Films::class,
                'choice_label' => 'titre',
            ]);
    }

    public function configureOptions (OptionsResolver $resolver): void
    {
        $resolver->setDefaults ([
            'data_class' => Seance::class,
        ]);
    }
}
