<?php

namespace App\Controller;

use App\Entity\MajeurEntity;
use App\Entity\ParametreMissionEntity;
use App\Form\ParametreMissionType;
use App\Repository\MajeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ParametreMissionController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * Constructeur
     *
     * @param $session SessionInterface
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("user/parametremissions", name="user_parametremissions")
     */
    public function index()
    {
        return $this->render('parametre_mission/index.html.twig', [
            'controller_name' => 'ParametreMissionController',
        ]);
    }

    /**
     * @Route("user/parametremission/add/{id}", name="user_parametremission_add")
     */
    public function add(MajeurEntity $majeur, Request $request, MajeurRepository $majeurRepository)
    {
        $pm = new ParametreMissionEntity();
        $pm->setMajeur($majeur);

        $form = $this->createForm(ParametreMissionType::class, $pm);
        $form->handleRequest($request);

        return $this->render('parametre_mission/new_or_edit.html.twig', [
            'page_title' => 'Paramètres de la mission',
            'form' => $form->createView(),
            'baseEntity' => $pm,
            'url_back' => 'user_majeurs',
        ]);
    }
}
