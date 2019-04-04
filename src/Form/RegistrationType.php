<?php
// src/AppBundle/Form/RegistrationType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class RegistrationType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
       $builder->add('firstname');
       $builder->add('lastname');
       $builder->add('phonenumber' , IntegerType::class);
   }

   public function getParent()
   {
       return 'FOS\UserBundle\Form\Type\RegistrationFormType';
   }
   public function getBlockPrefix()
   {
       return 'app_user_registration';
   }
   public function getName()
   {
       return $this->getBlockPrefix();
   }
}
