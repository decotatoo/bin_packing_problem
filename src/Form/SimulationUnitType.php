<?php

namespace App\Form;

use App\Entity\SimulationUnit;
use App\Entity\Unit;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SimulationUnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('qty')
            ->add('unit', EntityType::class, [
                'class' => Unit::class,
                'choice_label' => function($choice, $key, $value) {
                    return sprintf(
                        '%s (%s) %d gram [%.2f × %.2f × %.2f cm]',
                        $choice->getRef(),
                        $choice->getName(),
                        $choice->getWeight(),
                        $choice->getW()/10,
                        $choice->getL()/10,
                        $choice->getH()/10
                    );
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SimulationUnit::class,
        ]);
    }
}
