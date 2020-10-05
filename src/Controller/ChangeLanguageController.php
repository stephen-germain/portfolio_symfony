<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChangeLanguageController extends AbstractController
{
    /**
     * @Route("/language/{langue}", name="change_language")
     */
    public function changeLanguage($langue, Request $request)
    {
        $request->getSession()->set('_locale', $langue);

        return $this->redirect($request->headers->get('referer'));
    }
}
