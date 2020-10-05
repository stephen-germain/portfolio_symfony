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
    public function index(SkillsRepository $skillRepository, ProjectRepository $projectRepository, \Swift_Mailer $mailer, Request $request)
    {
        $skills = $skillRepository->findAll();
        $projects = $projectRepository->findAll();

        $formulaireContact = $this->createForm(ContactType::class);
        $formulaireContact->handleRequest($request);

        if($formulaireContact->isSubmitted() && $formulaireContact->isValid()){
            $infos = $formulaireContact->getData();
            $mail = (new \Swift_Message('Demande de contact'))
                ->setFrom($infos['email'])
                ->setTo('stephen.germain971@gmail.com')
                ->setBody(
                    $this->renderView(
                        'contact/email.html.twig', [
                            'nom' => $infos['nom'],
                            'prenom' => $infos['prenom'],
                            'mail' => $infos['mail'],
                            'objet' => $infos['objet'],
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
            'skills' => $skills,
            'projects' => $projects,
            'formulaireDeContact' => $formulaireContact->createView(),
        ]);
    }

}
