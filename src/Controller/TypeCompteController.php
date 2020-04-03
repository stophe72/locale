<?php

namespace App\Controller;

use App\Entity\TypeCompteEntity;
use App\Form\TypeCompteType;
use App\Repository\TypeCompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TypeCompteController extends AbstractController
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
     * @Route("user/typecomptes", name="user_typecomptes")
     */
    public function index(TypeCompteRepository $typeCompteRepository)
    {
        return $this->render('type_compte/index.html.twig', [
            'typeComptes' => $typeCompteRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des types de compte',
        ]);
    }

    /**
     * @Route("user/typecompte/add", name="user_typecompte_add")
     */
    public function add(Request $request)
    {
        $typeCompte = new TypeCompteEntity();

        $form = $this->createForm(TypeCompteType::class, $typeCompte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeCompte);
            $em->flush();

            return $this->redirectToRoute('user_typecomptes');
        }

        return $this->render(
            'type_compte/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouveau type de compte',
                'baseEntity' => $typeCompte,
                'url_back'    => 'user_typecomptes',
            ]
        );
    }

    /**
     * @Route("user/typecompte/edit/{id}", name="user_typecompte_edit")
     */
    public function edit(TypeCompteEntity $typeCompte, Request $request)
    {
        $form = $this->createForm(TypeCompteType::class, $typeCompte);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($typeCompte->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_typecomptes');
        }

        return $this->render(
            'type_compte/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un type de compte',
                'baseEntity' => $typeCompte,
                'url_back'    => 'user_typecomptes',
            ]
        );
    }
}
