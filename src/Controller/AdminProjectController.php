<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminProjectController extends AbstractController
{
    /**
     * @Route("/admin/project", name="admin_project")
     */
    public function index()
    {
        return $this->render('admin/adminProject.html.twig', [
            'controller_name' => 'AdminProjectController',
        ]);
    }
}
