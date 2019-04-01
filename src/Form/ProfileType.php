<?php
// src/AppBundle/Form/ProfileType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
class ProfileType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
       $builder->add('last_name');
       $builder->add('phone_number');
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
