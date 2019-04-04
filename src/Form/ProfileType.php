<?php
// src/AppBundle/Form/ProfileType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProfileType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
       $builder->add('firstname');
       $builder->add('lastname');
       $builder->add('phonenumber', IntegerType::class);
       $builder->remove('current_password');
   }
   public function getParent()
   {
       return 'FOS\UserBundle\Form\Type\ProfileFormType';
   }
   public function getBlockPrefix()
   {
       return 'app_user_profile';
   }
   public function getName()
   {
       return $this->getBlockPrefix();
   }
}
