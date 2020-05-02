<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PatrimoineController extends AbstractController
{
    /**
     * @Route("/patrimoine", name="patrimoine")
     */
    public function index()
    {
        return $this->render('patrimoine/index.html.twig', [
            'controller_name' => 'PatrimoineController',
        ]);
    }
}
