<?php

namespace App\Controller\Admin;

use App\Entity\Cinemas;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CinemasCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cinemas::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Cinémas'),
            TextField::new ('ville', 'Villes'),
            TextField::new('adresse', 'Adresses'),
            CollectionField::new ('film' ,'Films'),
            CollectionField::new ('salles')
        ];
    }

}
