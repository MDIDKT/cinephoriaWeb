<?php

namespace App\Controller\Admin;

use App\Entity\Reservations;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;


class ReservationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn (): string
    {
        return Reservations::class;
    }

    public function configureFields (string $pageName): iterable
    {
        return [
            AssociationField::new ('cinemas'),
            AssociationField::new ('films'),
            AssociationField::new ('seances'),
            IntegerField::new ('nombrePlaces'),
            BooleanField::new ('typePMR'),
            MoneyField::new ('prixTotal')
                ->setCurrency ('EUR')
                ->setStoredAsCents (false)
                ->setCustomOption ('storedAsCents', false)
                /*->setFormTypeOption('mapped', false)*/
                ->setFormTypeOption ('disabled', true)

        ];
    }

}
