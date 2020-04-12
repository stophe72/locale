<?php

namespace App\Controller;

use App\Entity\ProtectionEntity;
use App\Form\ProtectionType;
use App\Repository\ProtectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProtectionController extends AbstractController
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
     * @Route("user/protections", name="user_protections")
     */
    public function index(ProtectionRepository $protectionRepository)
    {
        return $this->render('protection/index.html.twig', [
            'protections' => $protectionRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des protections',
        ]);
    }

    /**
     * @Route("user/protection/add", name="user_protection_add")
     */
    public function add(Request $request)
    {
        $protection = new ProtectionEntity();

        $form = $this->createForm(ProtectionType::class, $protection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($protection);
            $em->flush();

            return $this->redirectToRoute('user_protections');
        }

        return $this->render(
            'protection/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle protection',
                'baseEntity' => $protection,
                'url_back'    => 'user_protections',
            ]
        );
    }

    /**
     * @Route("user/protection/edit/{id}", name="user_protection_edit")
     */
    public function edit(ProtectionEntity $protection, Request $request)
    {
        $form = $this->createForm(ProtectionType::class, $protection);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($protection->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_protections');
        }

        return $this->render(
            'protection/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une protection',
                'baseEntity' => $protection,
                'url_back'    => 'user_protections',
            ]
        );
    }
}