<?php

namespace App\Controller\Admin;

use App\BoxPacker\TestBox;
use App\BoxPacker\TestItem;
use App\Entity\Master;
use App\Entity\Simulation;
use App\Form\SimulationUnitType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use DVDoug\BoxPacker\InfalliblePacker;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SimulationCrudController extends AbstractCrudController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public static function getEntityFqcn(): string
    {
        return Simulation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name')
            ->addWebpackEncoreEntries('app');

        yield AssociationField::new('masters', 'Master Boxes')
            ->hideOnIndex()
            ->setFormType(EntityType::class)
            ->setFormTypeOption('class', Master::class)
            ->setFormTypeOption('multiple', true)
            ->setFormTypeOption('choice_label', function($choice, $key, $value) {
                return sprintf(
                    '%s (%s) [Inner: %.2f × %.2f × %.2f cm] [Outer: %.2f × %.2f × %.2f cm]',
                    $choice->getRef(),
                    $choice->getName(),
                    $choice->getInW()/10,
                    $choice->getInL()/10,
                    $choice->getInD()/10,
                    $choice->getOutW()/10,
                    $choice->getOutL()/10,
                    $choice->getOutD()/10
                );
            })
            ->addHtmlContentsToHead(sprintf('<script>const results = %s;</script>', json_encode($this->getContext()->getEntity()->getInstance()?->getResult())));

        yield CollectionField::new('simulationUnits', 'Units Ordered')
            ->hideOnIndex()
            ->setFormTypeOption('entry_type', SimulationUnitType::class)
            ->setEntryIsComplex(true);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setResult($this->doSimulation($entityInstance));

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setResult($this->doSimulation($entityInstance));

        parent::persistEntity($entityManager, $entityInstance);
    }

    private function doSimulation(&$entityInstance)
    {
        $packer = new InfalliblePacker();

        $masters = $entityInstance->getMasters();

        if ($masters->count() === 0) {
            $masterRepository = $this->doctrine->getRepository(Master::class);
            $masters = $masterRepository->findAll();

            if (count($masters) === 0) {
                return;
            }
        }

        foreach ($masters as $master) {
            $packer->addBox(new TestBox($master));
        }

        $simulationUnits = $entityInstance->getSimulationUnits();

        foreach ($simulationUnits as $simulationUnit) {
            for ($i = 0; $i < $simulationUnit->getQty(); $i++) {
                $packer->addItem(new TestItem($simulationUnit->getUnit()));
            }
        }

        $packed = array_map(function ($pb) {
            $_pb = $pb->jsonSerialize();
            $_pb['box'] = $pb->getBox()->jsonSerialize();

            $_pb['weight'] = $pb->getWeight();
            $_pb['volume'] = $pb->getBox()->getOuterDepth() * $pb->getBox()->getOuterWidth() * $pb->getBox()->getOuterLength();
            $_pb['items'] = [];

            foreach (iterator_to_array($pb->getItems()) as $item) {
                $_item = $item->jsonSerialize();
                $_item['id'] = $item->getItem()->getUnit()->getRef();
                $_pb['items'][] = $_item;
            }

            return $_pb;
        }, $packer->pack()->jsonSerialize());

        $unpackedItems = $packer->getUnpackedItems()->getIterator();

        return [
            'packed' => $packed,
            'unpacked' => $unpackedItems,
        ];
    }
}
