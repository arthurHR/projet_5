<?php

namespace App\Form;

use App\Entity\Header;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class HeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subtitle')
            ->add('imageFile', VichImageType::class, array(
                'required' => false,
                'allow_delete' => false, // not mandatory, default is true
                'download_link' => false, // not mandatory, default is true
                'image_uri' => true,
                'download_uri' => true,
                'attr' => ['onChange' => 'previewFile(this)'],
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Header::class,
        ]);
    }
}
