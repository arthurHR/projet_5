<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\findData;
use App\Services\findEmail;
use App\Entity\Skills;
use App\Form\SkillsType;
use App\Repository\SkillsRepository;
use App\Entity\Header;
use App\Form\HeaderType;
use App\Repository\HeaderRepository;
use App\Entity\About;
use App\Form\AboutType;
use App\Repository\AboutRepository;
use App\Repository\ProjectsRepository;
use App\Entity\Projects;
use App\Form\ProjectsType;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\UserBundle\Model\UserManagerInterface;
use App\Entity\User;
use Mailgun\Mailgun;



class BlogController extends AbstractController
{
    /**
     * @Route("/" , name="main")
     */
    public function mainAction(Request $request , HeaderRepository $headerRepo) {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            return $this->redirectToRoute('home', ['currentUser' => $user]);
        } else {
            $userInfos = $headerRepo->findAll();
            return $this->render('blog/views/main.html.twig', ['userInfos' => $userInfos]);
        }
    }

    /**
     * @Route("/showUsers" , name="users")
     */
    public function showUsersAction(HeaderRepository $headerRepo) {
        $userInfos = $headerRepo->findAll();
        return $this->render('blog/views/users.html.twig', ['userInfos' => $userInfos]);
    }
    

    /**
     * @Route("/user/{currentUser}" , name="home")
     */
    public function homeAction(Request $request, findData $findData, $currentUser) {
       /* if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
          if ($user == $currentUser or $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){*/
                $data = $findData->data;
                return $this->render('blog/home.html.twig', ['data' => $data]);
           /* } else {
                return $this->redirectToRoute('fos_user_security_logout');
            }
        } else {
            $data = $findData->data;
            return $this->render('blog/home.html.twig', ['data' => $data]);
        }*/
    }

      /**
     * @Route("/deleteUser/{User}" , name="deleteUser")
     */
    public function deleteUserAction( $User, UserManagerInterface $userManager) {
        $user = $userManager->findUserByUsername($User);
        $userManager->deleteUser($user);
        return $this->redirectToRoute('users');
    }

     /**
     * @Route("/addSkill" , name="addSkill", methods={"POST"} )
     */
    public function addSkillAction(Request $request)
    {
        
        $skills = new Skills();
        $form = $this->createForm(SkillsType::class, $skills, array(
            'action' => $this->generateUrl($request->get('_route'))
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $entityManager->persist($skills);
            $skills->setUser($user);
            $entityManager->flush();
            return new Response(' #skills');
        }
        return $this->render('blog/views/forms/addSkill.html.twig', [
            'form' => $form->createView(),
        ]);   
    } 
    
     /**
     * @Route("/addProject" , name="addProject", methods={"POST"} )
     */
    public function addProjectAction(Request $request)
    {
        
        $projects = new Projects();
        $form = $this->createForm(ProjectsType::class, $projects, array(
            'action' => $this->generateUrl($request->get('_route'))
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $entityManager->persist($projects);
            $projects->setUser($user);
            $entityManager->flush();
            return new Response(' #projects');
        }
        return $this->render('blog/views/forms/addProject.html.twig', [
            'form' => $form->createView(),
        ]);   
    } 

    
    /**
     * @Route("/updateSkill" , name="updateSkill",  methods={"POST"})
     */
    public function updateSkillAction(Request $request)
    {             

        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $skills = $entityManager->getRepository(Skills::class)->find($id);
        $form = $this->createForm(SkillsType::class, $skills, array(
            'action' => $this->generateUrl($request->get('_route'), array('id' => $id))
        ));

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($skills);
                $entityManager->flush();
                return new Response(' #skills');
            }
        return $this->render('blog/views/forms/updateSkill.html.twig', [
            'form' => $form->createView(),
        ]);   
    } 

    /**
     * @Route("/updateProject" , name="updateProject",  methods={"POST"})
     */
    public function updateProjectAction(Request $request)
    {             

        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $projects = $entityManager->getRepository(Projects::class)->find($id);
        $form = $this->createForm(ProjectsType::class, $projects, array(
            'action' => $this->generateUrl($request->get('_route'), array('id' => $id))
        ));

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($projects);
                $entityManager->flush();
                return new Response(' #projects');
            }
        return $this->render('blog/views/forms/updateProject.html.twig', [
            'form' => $form->createView(),
        ]);   
    } 

    /**
    * @Route("/deleteSkill", name="deleteSkill", methods={"POST"})
    */
    public function deleteSkillAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $id = $request->get('id');
            $entityManager = $this->getDoctrine()->getManager();

            $skills = $entityManager->getRepository(Skills::class)->find($id);

            $entityManager->remove($skills);
            $entityManager->flush();
            return new Response(' #skills');               
        }
    }

    /**
    * @Route("/deleteProject", name="deleteProject", methods={"POST"})
    */
    public function deleteProjectAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $id = $request->get('id');
            $entityManager = $this->getDoctrine()->getManager();
            $projects= $entityManager->getRepository(Projects::class)->find($id);
            $entityManager->remove($projects);
            $entityManager->flush();
            return new Response(' #projects');               
        }
    }

    /**
     * @Route("/updateHeader" , name="updateHeader",  methods={"POST"})
     */
    public function updateHeaderAction(Request $request)
    {             
        $userId = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $header = $entityManager->getRepository(Header::class)->findBy(array('user' => $userId));
        $form = $this->createForm(HeaderType::class, $header[0], array(
            'action' => $this->generateUrl($request->get('_route'))
        ));
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($header[0]);
                $entityManager->flush();
                return new Response(' #header');
            }
            
        return $this->render('blog/views/forms/updateHeader.html.twig', [
            'form' => $form->createView(),
        ]);   
    } 

     /**
     * @Route("/updateAbout" , name="updateAbout",  methods={"POST"})
     */
    public function updateAboutAction(Request $request)
    {             
        $userId = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $about = $entityManager->getRepository(About::class)->findBy(array('user' => $userId));
        $form = $this->createForm(AboutType::class, $about[0], array(
            'action' => $this->generateUrl($request->get('_route'))
        ));
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($about[0]);
                $entityManager->flush();
                return new Response(' #about');
            }
            
        return $this->render('blog/views/forms/updateAbout.html.twig', [
            'form' => $form->createView(),
        ]);   
    } 
    

     /**
     * @Route("/sendMessage", name="sendMessage", methods={"POST"})
     */
    public function sendMessageAction(Request $request, findEmail $findEmail, UserManagerInterface $userManager)
    { 
        $mgClient = new Mailgun('e5893aaf205e529fe8f860c4df40c55a-dc5f81da-cccad496');
        $domain = "sandbox0d7816520a324f3283d0c987b731608b.mailgun.org";
        $url = $request->headers->get('referer');
        $emailUser = $findEmail->findEmail($userManager, $url);
        $message = array('name','from','content'); 
        $form = $this->createForm(ContactType::class, $message, array(
            'action' => $this->generateUrl($request->get('_route'))
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $messageContent = $this->render('blog/views/email/email.html.twig', ['contactData' => $contactFormData]);
            $result = $mgClient->sendMessage($domain, array(
                'from'    =>  $contactFormData['from'],
                'to'      =>  $emailUser,
                'subject' => 'CreateYourPortfolio',
                'text'    =>  $contactFormData['content']
            ));
           $this->addFlash('successMessage', 'Votre message a bien été envoyé');
           return new Response(' #message');
        }
        return $this->render('blog/views/forms/contact.html.twig', [
            'form' => $form->createView(),
        ]);

        
       /* $message = (new \Swift_Message('You Got Mail!'))
        ->setFrom($contactFormData['from'])
        ->setTo($emailUser)
        ->setReplyTo($contactFormData['from'])
        ->setBody($messageContent, 'text/html');
    $mailer->send($message);*/
    }
}
