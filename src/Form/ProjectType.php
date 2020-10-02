<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Nom du site',
                'attr' => [
                    'placeholder' => 'titre'
                ]
            ])
            ->add('text', TextType::class, [
                'required' => true,
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'description du site'
                ]
            ])
            ->add('img', FileType::class, [
                'required' => true,
                'label' => 'Image du site',
                'attr' => [
                    'placeholder' => 'ex.: photo.png'
                ]
            ])
            ->add('url', TextType::class, [
                'required' => true,
                'label' => 'Adresse du site',
                'attr' => [
                    'placeholder' => 'https://monsite.fr'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
