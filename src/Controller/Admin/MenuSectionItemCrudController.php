<?php

namespace App\Controller\Admin;

use App\Entity\MenuSectionItem;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class MenuSectionItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MenuSectionItem::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add(EntityFilter::new('section')->autocomplete());
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield ImageField::new('image')
            ->setBasePath('uploads/images/')
            ->setUploadDir('public/uploads/images/')
            ->setUploadedFileNamePattern('[slug]-[randomhash].[extension]')
            ->setRequired($pageName !== Crud::PAGE_EDIT)
            ->setFormTypeOptions([
                'allow_delete' => false
            ]);
        yield TextField::new('name')
            ->setFormTypeOptions([
                'attr' => [
                    'maxlength' => 255
                ]
            ]);
        yield TextareaField::new('description')
            ->setFormTypeOptions([
                'attr' => [
                    'maxlength' => 1000
                ]
            ]);
        yield TextField::new('price');
        yield IntegerField::new('position')->hideWhenCreating();
        yield AssociationField::new('section')->autocomplete();
    }

    public function createEntity(string $entityFqcn)
    {
        return parent::createEntity($entityFqcn)
            ->setPosition(-1);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::deleteEntity($entityManager, $entityInstance);

        $imagePath = $this->getParameter('kernel.project_dir') . '/public/uploads/images/' . $entityInstance->getImage();
        unlink($imagePath);
    }
}
