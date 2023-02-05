<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CharacterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Character::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Characters')
            ->setEntityLabelInSingular('Character')
            ->setDefaultSort(['id'=>'desc']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX,Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {

        yield TextField::new('name', 'Name');
        yield TextField::new('img', 'Image');
        yield TextField::new('about', 'Bio');
        yield AssociationField::new('anime', 'Anime')
            ->setCrudController(AnimeCrudController::class);


    }

}
