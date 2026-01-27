<?php

namespace App\Controller\Admin;

use App\Entity\MenuSection;
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
}
