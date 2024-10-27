<?php

namespace App\Form;

use App\Entity\Cinemas;
use App\Entity\Films;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
class FilmsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'download_label' => 'Télécharger',
                'asset_helper' => true,
                'delete_label' => 'Supprimer',
            ])
            ->add('ageMinimum')
            ->add('coupDeCoeur')
            ->add('note')
            ->add('qualite')
/*            ->add('Cinemas', EntityType::class, [
                'class' => Cinemas::class,
                'choice_label' => 'nom',
                'multiple' => true,
            ])*/

/*            ->add('cinemas', EntityType::class, [
                'class' => Cinemas::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Films::class,
        ]);
    }
}
