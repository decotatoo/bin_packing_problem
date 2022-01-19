<?php

namespace App\Controller\Admin;

use App\Entity\Master;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class MasterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Master::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('ref', 'Reference'),
            Field::new('name', 'Name'),
            Field::new('base_weight', 'Base Weight (g)'),
            Field::new('max_weight', 'Capacity/Max Weight (g)'),
            Field::new('in_w', 'Inner Width (mm) [x]'),
            Field::new('in_l', 'Inner Length (mm) [y]'),
            Field::new('in_d', 'Inner Depth (mm) [z]'),
            Field::new('out_w', 'Outer Width (mm) [x]'),
            Field::new('out_l', 'Outer Length (mm) [y]'),
            Field::new('out_d', 'Outer Depth (mm) [z]'),
        ];
    }
}
