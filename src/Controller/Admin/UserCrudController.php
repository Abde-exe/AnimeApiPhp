<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\FavAnimeType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Users')
            ->setEntityLabelInSingular('user')
            ->setDefaultSort(['id'=>'desc']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX,Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {

        yield TextField::new('name', 'Name');
        yield TextField::new('email', 'Email');
        yield TextField::new('password', 'Password')
        ->onlyOnForms();
        /*yield CollectionField::new('favAnimes', 'Favorites animes')
            ->setEntryIsComplex(true)
            ->setEntryType(FavAnimeType::class)
        ->setTemplatePath('admin/user/favAnimes.html.twig');
        yield CollectionField::new('favCharacters', 'Favorites characters')
        ->setTemplatePath('admin/user/favCharacters.html.twig');*/


    }
}
