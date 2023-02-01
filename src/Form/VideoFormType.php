<?php

namespace App\Form;

use App\Entity\Video;
use App\Entity\VideoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VideoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('videoType', EntityType::class, [
            'label' => 'Type',
            'class' => VideoType::class,
            'choice_label' => 'name',
            'multiple' => false,
            'expanded'      => false,
            'choice_value'  => 'id',
            'attr'          => [
                'class' => 'form-select mb-3'
            ],
        ])
        ->add('name', TextType::class, [
            'label' => 'Titre',
            'attr' => [
                'class' => 'form-control mb-3',
            ]
        ])
        ->add('synopsis', TextareaType::class, [
            'attr' => [
                'class' => 'form-control mb-3',
            ]
        ])
        ->add('years', TextType::class, [
            'label' => 'Année de sortie',
            'attr' => [
                'class' => 'form-control mb-3',
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => [
                'class' => 'btn btn-primary w-25'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
