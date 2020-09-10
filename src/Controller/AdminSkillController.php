<?php

namespace App\Controller;

use App\Entity\Skills;
use App\Form\SkillsType;
use App\Repository\SkillsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminSkillController extends AbstractController
{
    /**
     * @Route("/admin/skill", name="admin_skills")
     */
    public function index(SkillsRepository $skillsRepository)
    {
        $skill = $skillsRepository->findAll();
        
        return $this->render('admin/adminSkills.html.twig', [
            'skills' => $skill,
        ]);
    }

    /**
     * @Route("/admin/create", name="skills_create")
     */
    public function createSkills(Request $request)
    {
        $skill = new Skills();

        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            if($form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($skill);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'La compétences à été ajoutées'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('admin_skills');
        }

        return $this->render('admin/adminForm.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/update-{id}", name="skills_update")
     */
    public function updateSkills(SkillsRepository $skillsRepository, $id, Request $request){

        $skill = $skillsRepository->find($id);

        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            if($form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($skill);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'La compétences à été modifiée'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('admin_skills');
        }

        return $this->render('admin/adminForm.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete-{id}", name="skills_delete")
     */
    public function deleteSkill(SkillsRepository $skillsRepository, $id){

        $skill = $skillsRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($skill);
        $manager->flush();

        $this->addFlash(
            'danger',
            'La compétence à bien été supprimée'
        );

        return $this->redirectToRoute('admin_skills');

    }
}
