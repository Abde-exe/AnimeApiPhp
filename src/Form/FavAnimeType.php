<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Anime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FavAnimeType extends AbstractType{
public function buildForm(FormBuilderInterface $builder, array $options):void
{
   $builder->add('usersFaving',EntityType::class, [
       'class'=>Anime::class,
       'choice_label'=>'title']);
}
public function configureOptions(OptionsResolver $resolver):void
{
   $resolver->setDefault('data_class',Anime::class);
}

}