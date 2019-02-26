<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\findData;
use App\Entity\Skills;
use App\Form\SkillsType;
use App\Repository\SkillsRepository;
use App\Entity\About;
use App\Form\AboutType;
use App\Repository\AboutRepository;
use App\Repository\ProjectsRepository;
use App\Entity\Projects;
use App\Form\ProjectsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class BlogController extends AbstractController
{

    /**
     * @Route("/" , name="home")
     */
    public function mainAction(findData $findData) {
        $data = $findData->data;
        return $this->render('blog/home.html.twig', ['data' => $data]);
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
                $entityManager->persist($skills);
                $entityManager->flush();
                return new Response(' #skills');
            }
            return $this->render('blog/views/forms/addSkill.html.twig', [
                'form' => $form->createView(),
            ]);   
    } 
    
     /**
     * @Route("/addProject" , name="addProject" )
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
                $entityManager->persist($projects);
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
    public function updateSkillAction(Request $request, SkillsRepository $repoSkills)
    {             

            $em = $this->getDoctrine()->getManager();
            $skills = new Skills();
            $id = $request->get('id');
            $skills = $em->getRepository(Skills::class)->find($id);
            $form = $this->createForm(SkillsType::class, $skills, array(
                'action' => $this->generateUrl($request->get('_route'), array('id' => $id))
            ));

            $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em->persist($skills);
                    $em->flush();
                    return new Response(' #skills');
                }
            return $this->render('blog/views/forms/updateSkill.html.twig', [
                'form' => $form->createView(),
            ]);   
    } 

    /**
     * @Route("/updateProject" , name="updateProject",  methods={"POST"})
     */
    public function updateProjectAction(Request $request, ProjectsRepository $repoProjects)
    {             

            $em = $this->getDoctrine()->getManager();
            $projects = new Projects();
            $id = $request->get('id');
            $projects = $em->getRepository(Projects::class)->find($id);
            $form = $this->createForm(ProjectsType::class, $projects, array(
                'action' => $this->generateUrl($request->get('_route'), array('id' => $id))
            ));

            $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em->persist($projects);
                    $em->flush();
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
                $em = $this->getDoctrine()->getManager();

                $skills = $em->getRepository(Skills::class)->find($id);

                $em->remove($skills);
                $em->flush();
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
                $em = $this->getDoctrine()->getManager();

                $projects= $em->getRepository(Projects::class)->find($id);

                $em->remove($projects);
                $em->flush();
                return new Response(' #projects');               
        }
    }

     /**
     * @Route("/updateAbout" , name="updateAbout",  methods={"POST"})
     */
    public function updateAboutAction(Request $request, AboutRepository $repoAbout)
    {             

            $em = $this->getDoctrine()->getManager();
            $about = new About();
            $id = 1;
            $about = $em->getRepository(About::class)->find($id);
            $form = $this->createForm(AboutType::class, $about, array(
                'action' => $this->generateUrl($request->get('_route'), array('id' => $id))
            ));

            $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em->persist($about);
                    $em->flush();
                    return new Response(' #about');
                }
            return $this->render('blog/views/forms/updateAbout.html.twig', [
                'form' => $form->createView(),
            ]);   
    } 
}