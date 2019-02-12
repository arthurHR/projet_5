<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\findData;
use App\Entity\Skills;
use App\Form\SkillsType;
use App\Repository\SkillsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class BlogController extends AbstractController
{

    /**
     * @Route("/" , name="home")
     */
    public function home(findData $findData) {
        $data = $findData->data;
        return $this->render('blog/home.html.twig', ['data' => $data]);
    }

     /**
     * @Route("/addSkill" , name="addSkill")
     */
    public function addSkill(Request $request)
    {
        $skills = new Skills;
        $form = $this->createForm(SkillsType::class, $skills);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
           

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($skills);
            $entityManager->flush();
            return $this->redirectToRoute('home');
            


        }

        return $this->render('blog/views/addSkills.html.twig', [
            'SkillsType' => $form->createView(),
        ]);

    } 

    /**
    * @Route("/deleteSkill", name="deleteSkill", methods={"POST"})
    */
    public function deleteSkill(Request $request)
    {
        if($request->isXmlHttpRequest()){
                $id = $request->get('id');
                $em = $this->getDoctrine()->getManager();

                $skills = $em->getRepository(Skills::class)->find($id);

                $em->remove($skills);
                $em->flush();
                /* return $this->redirectToRoute('home'); */
                return new JsonResponse('good');
                
        }
    }

    /**
     * @Route("/refreshSkills" , name="refreshSkills")
     */
    public function refreshSkills(findData $findData) {
        $data = $findData->data;
        return $this->render('blog/views/skills.html.twig', ['data' => $data]);
    }
}