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
                    $img->move(
                        $this->getParameter('photos_site'),
                        $newNomImg
                    );
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
                    'Le projet à bien été ajouté'
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
    /**
     * @Route("/admin/updateProject-{id}", name="update_project")
     */
    public function updateProject(ProjectRepository $projectRepository, $id, Request $request)
    {
        $project = $projectRepository->find($id);
        
        $oldNomImg = $project->getImg();
        $oldCheminImg = $this->getParameter('photos_site').'/'.$oldNomImg;

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        $img = $form['img']->getData();
        
        if($form->isSubmitted()){
            if($form->isValid()){

                if($oldNomImg != NULL){
                    unlink($oldCheminImg);
                }
                
                $nomImg = md5(uniqid());
                $extensionImg = $img->guessExtension();
                $newNomImg = $nomImg.'.'.$extensionImg;

                try{
                    $img->move(
                        $this->getParameter('photos_site'),
                        $newNomImg
                    );
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
                    'Le projet à bien été modifié'
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
    /**
     * @Route("/admin/deleteProject-{id}", name="delete_project")
     */
    public function deleteProject(ProjectRepository $projectRepository, $id)
    {
        $project = $projectRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($project);
        $manager->flush();

        $this->addFlash(
            'danger',
            'La compétence à bien été supprimée'
        );
        
        return $this->redirectToRoute('admin_project');
    }

}
