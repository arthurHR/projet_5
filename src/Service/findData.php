<?php

namespace App\Service;


use App\Repository\SkillsRepository;
use App\Repository\ProjectsRepository;
use App\Repository\AboutRepository;
use App\Repository\HeaderRepository;
use App\Entity\Header;
use App\Entity\About;
use App\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\BlogController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;



class findData
{
    public $data;

    public function __construct(RequestStack $requestStack, SkillsRepository $repoSkills, ProjectsRepository $repoProjects, AboutRepository $repoAbout, HeaderRepository $repoHeader,  UserManagerInterface $userManager, EntityManagerInterface $entityManager)
    {
        /* $roles = "ROLE_SUPER_ADMIN"; */
        /* $admin=$repository->findByRoles($roles); */
        $request = $this->request = $requestStack->getCurrentRequest();
        $userName = $request->get('currentUser');
        $user = $userManager->findUserByUsername($userName);
        $header = $user->getHeaders();
        $about = $user->getAbouts();
        if(count($header) < 1 || count($about) < 1){
           $this->setDefaultContent($user, $entityManager);
        }
        $skills = $user->getSkills();
        $projects = $user->getProjects();
        $this->data = array(
            "user" => $user,
            /*"admin" => $admin,*/
            "header" => $header,
            "about" => $about,
            "skills" => $skills,
            "projects" => $projects,
        );
    }

    public function setDefaultContent ($user, $entityManager) {
        $newHeader = new Header();
        $newHeader->setTitle('Bienvenue sur votre Blog')
                  ->setSubtitle('Commencer à le personnaliser');
        $user->addHeader($newHeader);
        $newAbout = new About();
        $filename = 'C:\xampp\htdocs\blog\public\images\about\how-to-create-a-blog.png';
        $file = new UploadedFile($filename, $filename, null, false, true);
        $newAbout->setDescription('Personnaliser votre profil') 
                 ->setImageFile($file);            
        $user->addAbout($newAbout);
        $entityManager->persist($newHeader);
        $entityManager->persist($newAbout);
        $entityManager->flush();
    }

}