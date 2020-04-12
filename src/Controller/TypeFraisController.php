<?php

namespace App\Controller;

use App\Entity\TypeFraisEntity;
use App\Form\TypeFraisType;
use App\Repository\TypeFraisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TypeFraisController extends AbstractController
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
     * @Route("user/typesfrais", name="user_typesfrais")
     */
    public function index(TypeFraisRepository $typeFraisRepository)
    {
        return $this->render('type_frais/index.html.twig', [
            'typesFrais' => $typeFraisRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des types de frais',
        ]);
    }

    /**
     * @Route("user/typefrais/add", name="user_typefrais_add")
     */
    public function add(Request $request)
    {
        $typeFrais = new TypeFraisEntity();

        $form = $this->createForm(TypeFraisType::class, $typeFrais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeFrais);
            $em->flush();

            return $this->redirectToRoute('user_typesfrais');
        }

        return $this->render(
            'type_frais/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouveau type de frais',
                'baseEntity' => $typeFrais,
                'url_back' => 'user_typesfrais',
            ]
        );
    }

    /**
     * @Route("user/typefrais/edit/{id}", name="user_typefrais_edit")
     */
    public function edit(TypeFraisEntity $typeFrais, Request $request)
    {
        $form = $this->createForm(TypeFraisType::class, $typeFrais);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($typeFrais->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_typesfrais');
        }

        return $this->render(
            'type_frais/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Modifier un type de frais',
                'baseEntity' => $typeFrais,
                'url_back' => 'user_typesfrais',
            ]
        );
    }
}