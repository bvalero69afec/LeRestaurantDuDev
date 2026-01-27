<?php

namespace App\Controller\Admin;

use App\Entity\MenuSection;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MenuSectionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MenuSection::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name')
            ->setFormTypeOptions([
                'attr' => [
                    'maxlength' => 255
                ]
            ]);
        yield IntegerField::new('position')->hideWhenCreating();
    }

    public function createEntity(string $entityFqcn)
    {
        return parent::createEntity($entityFqcn)
            ->setPosition(-1);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $menuSectionItems = $entityInstance->getMenuSectionItems();

        parent::deleteEntity($entityManager, $entityInstance);

        foreach ($menuSectionItems as $menuSectionItem) {
            $imagePath = $this->getParameter('kernel.project_dir') . '/public/uploads/images/' . $menuSectionItem->getImage();
            unlink($imagePath);
        }
    }
}
