<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ParametreMissionController extends AbstractController
{
    /**
     * @Route("/parametre/mission", name="parametre_mission")
     */
    public function index()
    {
        return $this->render('parametre_mission/index.html.twig', [
            'controller_name' => 'ParametreMissionController',
        ]);
    }
}
