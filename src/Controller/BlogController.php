<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\findData;

class BlogController extends AbstractController
{

    /**
     * @Route("/" , name="home")
     */
    public function home(findData $findData) {
        $data = $findData->data;
        return $this->render('blog/home.html.twig', ['data' => $data]);
    }
}
