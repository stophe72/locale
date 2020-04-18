<?php

namespace App\Controller;

use App\Entity\FamilleCompteEntity;
use App\Form\FamilleCompteType;
use App\Repository\FamilleCompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FamilleCompteController extends AbstractController
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
     * @Route("user/famillecomptes", name="user_famillecomptes")
     */
    public function index(FamilleCompteRepository $familleCompteRepository)
    {
        $user = $this->security->getUser();

        return $this->render('famille_compte/index.html.twig', [
            'familleComptes' => $familleCompteRepository->findBy(['user' => $user->getId(),], ['libelle' => 'ASC']),
            'page_title' => 'Liste des familles de comptes',
        ]);
    }

    /**
     * @Route("user/famillecompte/add", name="user_famillecompte_add")
     */
    public function add(Request $request)
    {
        $familleCompte = new FamilleCompteEntity();

        $form = $this->createForm(FamilleCompteType::class, $familleCompte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($familleCompte);
            $em->flush();

            return $this->redirectToRoute('user_famillecomptes');
        }

        return $this->render(
            'famille_compte/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouvelle famille de comptes',
                'baseEntity' => $familleCompte,
                'url_back' => $this->generateUrl('user_famillecomptes'),
            ]
        );
    }

    /**
     * @Route("user/famillecompte/edit/{id}", name="user_famillecompte_edit")
     */
    public function edit(famillecompteEntity $familleCompte, Request $request)
    {
        $form = $this->createForm(FamilleCompteType::class, $familleCompte);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($familleCompte->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_famillecomptes');
        }

        return $this->render(
            'famille_compte/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une famille de comptes',
                'baseEntity' => $familleCompte,
                'url_back'    => $this->generateUrl('user_famillecomptes'),
            ]
        );
    }
}
