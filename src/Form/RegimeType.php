<?php

namespace App\Form;

use App\Entity\Regime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomRegime')
            ->add('duree')
            ->add('type')
            ->add('Save', SubmitType::class,['label'=>'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Regime::class,
        ]);
    }

    public function buildForm2(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Autres champs du formulaire
            ->add('uploadImage', FileType::class, [
                'label' => 'Upload image',
            ])
        ;
    }
}
