<?php

namespace App\Form;

use App\Entity\Eleves;
use App\Entity\Classes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ElevesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_eleve')
            ->add('prenom_eleve')
            ->add('classe_eleve', EntityType::class, [
                'class' => Classes::class,
                'choice_label' => 'nom_classe',
            ])
            ->add('date_naissance_eleve')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
        ]);
    }
}
