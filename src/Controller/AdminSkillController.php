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
        $skill1 = $skillsRepository->findByTechno(1);
        $skill2 = $skillsRepository->findByTechno(2);
        $skill3 = $skillsRepository->findByTechno(3);

        
        return $this->render('admin/adminSkills.html.twig', [
            'skill1' => $skill1,
            'skill2' => $skill2,
            'skill3' => $skill3,
        ]);
    }

    /**
     * @Route("/admin/create-skill", name="skills_create")
     */
    public function createSkills(Request $request)
    {
        $skill = new Skills();

        $form = $this->createForm(SkillsType::class, $skill);
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

                $skill->setImg($newNomImg);

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
     * @Route("/admin/update-skill-{id}", name="skills_update")
     */
    public function updateSkills(SkillsRepository $skillsRepository, $id, Request $request){

        $skill = $skillsRepository->find($id);

        $oldNomImg = $skill->getImg();
        $oldCheminImg = $this->getParameter('photos_site').'/'.$oldNomImg;

        $form = $this->createForm(SkillsType::class, $skill);
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

                $skill->setImg($newNomImg);

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
     * @Route("/admin/delete-skill-{id}", name="skills_delete")
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
