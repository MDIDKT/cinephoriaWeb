<?php

namespace App\Controller\Admin;

use App\Entity\Films;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FilmsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Films::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextField::new('description'),
            TextField::new ('affiche'),
            IntegerField::new ('ageMinimum'),
            BooleanField::new ('coupDeCoeur'),
            IntegerField::new ('note'),
            TextField::new ('qualite'),
        ];
    }

}
