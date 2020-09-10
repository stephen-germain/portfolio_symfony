<?php

namespace App\Form;

use App\Entity\Skills;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SkillsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                'label' => 'Langages',
                'attr' => [
                    'placeholder' => 'Langage'
                ]
            ])
            ->add('framework', TextType::class, [
                'required' => false,
                'label' => 'Framework',
                'attr' => [
                    'placeholder' => 'Framework'
                ]
            ])
            ->add('cms', TextType::class, [
                'required' => false,
                'label' => 'cms',
                'attr' => [
                    'placeholder' => 'CMS'
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
