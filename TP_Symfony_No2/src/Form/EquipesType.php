<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\Joueurs;
use App\Entity\Equipes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EquipesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomEquipe')
            ->add('clubEquipe', EntityType::class, [
                'class' => Club::class,
                'choice_label' => 'nomClub',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipes::class,
        ]);
    }
}
