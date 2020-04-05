<?php

namespace App\Controller;

use App\Entity\VisiteEntity;
use App\Form\VisiteType;
use App\Repository\MajeurRepository;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class VisiteController extends AbstractController
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
     * @Route("user/visites", name="user_visites")
     */
    public function index(VisiteRepository $visiteRepository)
    {
        $visites = $visiteRepository->getAllOrderByNomPrenom();
        return $this->render('visite/index.html.twig', [
            'visites' => $visites,
            'page_title' => 'Liste des visites',
        ]);
    }

    /**
     * @Route("user/visite/add", name="user_visite_add")
     */
    public function add(Request $request, MajeurRepository $majeurRepository)
    {
        $visite = new VisiteEntity();
        $majeurs =  $majeurRepository->getAllOrderByNomPrenom();

        $form = $this->createForm(VisiteType::class, $visite, ['majeurs' => $majeurs]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visite);
            $em->flush();

            return $this->redirectToRoute('user_visites');
        }

        return $this->render(
            'visite/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle visite',
                'baseEntity' => $visite,
                'url_back'    => 'user_visites',
            ]
        );
    }

    /**
     * @Route("user/visite/edit/{id}", name="user_visite_edit")
     */
    public function edit(VisiteEntity $visite, Request $request)
    {
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($visite->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_visites');
        }

        return $this->render(
            'visite/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une visite',
                'baseEntity' => $visite,
                'url_back'    => 'user_visites',
            ]
        );
    }
}
