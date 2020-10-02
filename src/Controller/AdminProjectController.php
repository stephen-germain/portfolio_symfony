<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminProjectController extends AbstractController
{
    /**
     * @Route("/admin/project", name="admin_project")
     */
    public function index(ProjectRepository $projectRepository)
    {
        $projects = $projectRepository->findAll();
        
        return $this->render('admin/adminProject.html.twig', [
            'projects' => $projects,
        ]);
    }/**
     * @Route("/admin/createProject", name="create_project")
     */
    public function createProject(Request $request)
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        $img = $form['img']->getData();
        
        if($form->isSubmitted()){
            if($form->isValid()){

                $nomImg = md5(uniqid());
                $extensionImg = $img->guessExtension();
                $newNomImg = $nomImg.'.'.$extensionImg;

                try{
                    $chemin = $this->getParameter('photos_site').'/'.$newNomImg;
                }
                catch(FileException $e){
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue lors de l\'importation de l\'image'
                    );
                }

                $project->setImg($newNomImg);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($project);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Le projets à bien été ajouté'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('admin_project');
        }
        
        return $this->render('admin/adminForm.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }

}
