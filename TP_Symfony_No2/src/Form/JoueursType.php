<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\Joueurs;
use App\Entity\Equipes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class JoueursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomJoueur')
            ->add('prenomJoueur')
            ->add('photoJoueur', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],

                        'mimeTypesMessage' => 'Veuillez entrer un format de document

                        valide',
                    ])
                ],
            ])
            ->add('dateNaissance')
            ->add('clubJoueur', EntityType::class, [
                'class' => Club::class,
                'choice_label' => 'nomClub',
            ])
            ->add('equipeJoueur', EntityType::class, [
                'class' => Equipes::class,
                'choice_label' => 'nomEquipe',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Joueurs::class,
        ]);
    }
}
