<?php

namespace App\Controller\Admin;

use App\Entity\Unit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class UnitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Unit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('ref', 'Reference'),
            Field::new('name', 'Name'),
            Field::new('weight', 'Weight (g)'),
            Field::new('w', 'Width (mm) [x]'),
            Field::new('l', 'Length (mm) [y]'),
            Field::new('h', 'Height (mm) [z]'),
        ];
    }
}
