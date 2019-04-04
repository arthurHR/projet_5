<?php
// src/AppBundle/Form/LogineType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
class LoginType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
       
   }
   public function getParent()
   {
       return 'FOS\UserBundle\Form\Type\loginFormType';
   }
   public function getBlockPrefix()
   {
       return 'app_user_login';
   }
   public function getName()
   {
       return $this->getBlockPrefix();
   }
}
