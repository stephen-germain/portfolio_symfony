<?php

namespace App\Controller;

use App\Repository\SkillsRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SkillsRepository $skillRepository, ProjectRepository $projectRepository)
    {
        $skills = $skillRepository->findAll();
        $projects = $projectRepository->findAll();


        return $this->render('home/index.html.twig', [
            'skills' => $skills,
            'projects' => $projects
        ]);
    }


}
