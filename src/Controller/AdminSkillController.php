<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminSkillController extends AbstractController
{
    /**
     * @Route("/admin/skill", name="admin_skills")
     */
    public function index()
    {
        return $this->render('admin/adminSkills.html.twig', [
            'controller_name' => 'AdminSkillController',
        ]);
    }
}
