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
    public function buildForm (FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add ('cinemas', EntityType::class, [
                'class' => Cinemas::class,
                'choice_label' => 'nom',
            ])
            ->add ('films', EntityType::class, [
                'class' => Films::class,
                'choice_label' => 'titre',
            ])
            ->add('nombrePlaces', null, [
                'attr' => ['class' => 'form-input mt-1 block w-full']
            ])
            ->add('typePMR', null, [
                'attr' => ['class' => 'form-checkbox mt-1 block']
            ])
            ->add('prixTotal', null, [
                'attr' => ['class' => 'form-input mt-1 block w-full']
            ])

/*            ->add ('seances', EntityType::class, [
                'class' => Seance::class,
                'choice_label' => function(Seance $seance) {
                    return $seance->getHeureDebut ()->format ('Y-m-d H:i:s');
                },
                'multiple' => true,
            ])*/;
    }

    public function configureOptions (OptionsResolver $resolver): void
    {
        $resolver->setDefaults ([
            'data_class' => Reservations::class,
        ]);
    }
}
