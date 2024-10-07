<?php

namespace App\Controller\Admin;

use App\Entity\Salles;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use SebastianBergmann\CodeCoverage\Report\Text;

class SallesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Salles::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('numeroSalle'),
            IntegerField::new('nombreSiege'),
            IntegerField::new('nombreSiegePMR'),
        ];
    }

}
