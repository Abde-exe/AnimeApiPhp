<?php

namespace App\Controller\Admin;

use App\Entity\Anime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AnimeCrudController extends AbstractCrudController
{
    public function __construct(private string $uploadDir)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Anime::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Animes')
            ->setEntityLabelInSingular('Anime')
            ->setDefaultSort(['id'=>'desc']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX,Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
     {

         yield TextField::new('title', 'Title');
         yield TextField::new('file', 'Cover' )
             ->setFormType(VichImageType::class)
             ->onlyOnForms();
         yield ImageField::new('image', 'Cover image')
             ->setBasePath($this->uploadDir.'/animes/')
             ->hideOnForm();
         yield TextField::new('genres', 'Genre');
         yield AssociationField::new('studio', 'Animation studio')
             ->setCrudController(StudioCrudController::class);


     }

}
