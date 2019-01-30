<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Skills;
use App\Repository\SkillsRepository;

class BlogController extends AbstractController
{

    /**
     * @Route("/" , name="home")
     */
    public function home() {
        return $this->render('blog/home.html.twig', ['title' => "bienvenu"]);
    }
    /**
     * @Route("/skill", name="skill")
     */
    public function showSkill(SkillsRepository $repo)
    {
        $skills = $repo->findAll();

        return $this->render('blog/skill.html.twig', [
            'skills' => $skills
        ]);
    }
}
