<?php

namespace App\Service;


use App\Repository\SkillsRepository;
use App\Repository\ProjectsRepository;
use App\Repository\AboutRepository;
use App\Repository\HeaderRepository;
use App\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;


class findData 
{
    public $data;

    public function __construct(SkillsRepository $repoSkills, ProjectsRepository $repoProjects, AboutRepository $repoAbout, HeaderRepository $repoHeader,  UserManagerInterface $userManager, EntityManagerInterface $em)
    {
        $users = $userManager->findUsers();
        $roles = "ROLE_SUPER_ADMIN";
        $repository=$em->getRepository(User::Class);
        $admin=$repository->findByRoles($roles);
        $header = $repoHeader->findAll();
        $about = $repoAbout->findAll();
        $skills = $repoSkills->findAll();
        $projects = $repoProjects->findAll();
        $this->data = array(
            "users" => $users,
            "admin" => $admin,
            "header" => $header,
            "about" => $about,
            "skills" => $skills,
            "projects" => $projects,
        );
    }
}