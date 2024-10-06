<?php

namespace App\Controller\Admin;

use App\Entity\Salles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SallesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Salles::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('cinema'),
            IntegerField::new('numeroSalle'),
            IntegerField::new('nombreSiege'),
            IntegerField::new('nombreSiegePMR'),
        ];
    }

}
