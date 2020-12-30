<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\SkillsRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SkillsRepository $skillsRepository, ProjectRepository $projectRepository, \Swift_Mailer $mailer, Request $request)
    {
        $skill1 = $skillsRepository->findByTechno(1);
        $skill2 = $skillsRepository->findByTechno(2);
        $skill3 = $skillsRepository->findByTechno(3);
        $projects = $projectRepository->findAll();

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $infos = $form->getData();
            $mail = (new \Swift_Message('Demande de contact'))
                ->setFrom($infos['email'])
                ->setTo('stephen.germain971@gmail.com')
                ->setBody(
                    $this->renderView(
                        'contact/email.html.twig', [
                            'nom' => $infos['nom'],
                            'prenom' => $infos['prenom'],
                            'email' => $infos['email'],
                            'message' => $infos['message']
                        ],
                        'text/html'
                    )
                );
            $mailer->send($mail);
            $this->addFlash(
                'success',
                'Votre message à bien été envoyé'
            );
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'skill1' => $skill1,
            'skill2' => $skill2,
            'skill3' => $skill3,
            'projects' => $projects,
            'formulaireDeContact' => $form->createView(),
        ]);
    }
}
