<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Proffesseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ClassesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_classe')
            ->add('professeur', EntityType::class, [
                'class' => Proffesseur::class,
                'choice_label' => 'nom_professeur',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Classes::class,
        ]);
    }
}
