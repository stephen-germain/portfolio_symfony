<?php

namespace App\Form;

use App\Entity\Skills;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SkillsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Langage'
                ]
            ])
            ->add('technologies', ChoiceType::class, [
                'choices' => [
                    'langage' => 1,
                    'framework' => 2,
                    'cms' => 3,
                ]
            ])
            ->add('img', FileType::class, [
                'required' => true,
                'mapped' => false,
                'label' => 'Image de la compétence',
                'attr' => [
                    'placeholder' => 'ex.: photo.png'
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
            'data_class' => Skills::class,
        ]);
    }
}
