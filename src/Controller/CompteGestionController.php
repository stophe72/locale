<?php

namespace App\Controller;

use App\Entity\CompteGestionEntity;
use App\Entity\MajeurEntity;
use App\Form\CompteGestionType;
use App\Repository\CompteGestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CompteGestionController extends AbstractController
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
     * @Route("user/comptegestions", name="user_comptesgestion")
     */
    public function index(CompteGestionRepository $compteGestionEntityRepository)
    {
        $operations = $compteGestionEntityRepository->findAll();

        return $this->render('compte_gestion/index.html.twig', [
            'operations' => $operations,
            'page_title' => 'Liste des opérations',
        ]);
    }

    /**
     * @Route("user/comptegestion/add", name="user_comptegestion_add")
     */
    public function add(Request $request)
    {
        $compteGestion = new CompteGestionEntity();

        $form = $this->createForm(CompteGestionType::class, $compteGestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($compteGestion);
            $em->flush();

            return $this->redirectToRoute('user_comptesgestion');
        }

        return $this->render(
            'compte_gestion/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle opération',
                'baseEntity' => $compteGestion,
                'url_back'    => 'user_comptesgestion',
            ]
        );
    }

    /**
     * @Route("user/comptegestion/edit/{id}", name="user_comptegestion_edit")
     */
    public function edit(CompteGestionEntity $compteGestion, Request $request)
    {
        $form = $this->createForm(CompteGestionType::class, $compteGestion);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($compteGestion->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_comptesgestion', ['id' => $compteGestion->getMajeur()->getId()]);
        }

        return $this->render(
            'compte_gestion/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une opération',
                'baseEntity' => $compteGestion,
                'url_back'    => 'user_comptesgestion',
            ]
        );
    }
}
