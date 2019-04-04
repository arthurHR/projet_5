<?php

namespace App\Services;

use App\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;




class findEmail
{
    public function findEmail ( $userManager, $url) {
        $segments = explode('/', $url);
        $numSegments = count($segments); 
        $userName = $segments[$numSegments - 1];
        $user = $userManager->findUserByUsername($userName);
        $userEmail = $user->getEmail();
        return $userEmail;
    }

  

}