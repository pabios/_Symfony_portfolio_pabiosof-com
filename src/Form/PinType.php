<?php

namespace App\Form;

use App\Entity\Pin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image JPG ou PNG',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'image',
                'download_label' => 'Telecharger',
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
            ])
            ->add('title')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Pin::class
        ]);
    }
}
