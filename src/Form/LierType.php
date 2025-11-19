<?php

namespace App\Form;

use App\Entity\Lier;
use App\Entity\Projet;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
            ])
            ->add('projet', EntityType::class, [
                'class' => Projet::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lier::class,
        ]);
    }
}
