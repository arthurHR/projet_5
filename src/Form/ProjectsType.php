<?php

namespace App\Form;

use App\Entity\Projects;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('link')
            ->add('imageFile', VichImageType::class, array(
                'required' => false,
                'allow_delete' => false, // not mandatory, default is true
                'download_link' => false, // not mandatory, default is true
                'image_uri' => true,
                'download_uri' => true,
                'attr' => ['onChange' => 'previewFile()'],
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
