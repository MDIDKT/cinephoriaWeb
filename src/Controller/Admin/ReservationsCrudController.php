<?php

namespace App\Controller\Admin;

use App\Entity\Reservations;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ReservationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservations::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new ('cinemas', 'Cinéma'),
            AssociationField::new ('films', 'Film'),
            AssociationField::new ('seances', 'Séance'),
            IntegerField::new ('nombrePlace', 'Nombre de places'),
            IntegerField::new ('typePMR', 'Type PMR ?'),
            MoneyField::new ('prixTotal', 'Prix total')
                ->setCurrency ('EUR')
                ->setStoredAsCents (false)
                ->setNumDecimals (2),
        ];
    }

}
