<?php

namespace App\Controller;

use App\Entity\LieuVieEntity;
use App\Form\LieuVieType;
use App\Repository\LieuVieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class LieuVieController extends AbstractController
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
     * @Route("user/lieu_vies", name="user_lieu_vies")
     */
    public function index(LieuVieRepository $lieuVieRepository)
    {
        return $this->render('lieu_vie/index.html.twig', [
            'lieuVies' => $lieuVieRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des lieux de vie',
        ]);
    }

    /**
     * @Route("user/lieu_vie/add", name="user_lieu_vie_add")
     */
    public function add(Request $request)
    {
        $lieuVie = new LieuVieEntity();

        $form = $this->createForm(LieuVieType::class, $lieuVie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lieuVie);
            $em->flush();

            return $this->redirectToRoute('user_lieu_vies');
        }

        return $this->render(
            'lieu_vie/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouveau lieu de vie',
                'baseEntity' => $lieuVie,
                'url_back'    => $this->generateUrl('user_lieu_vies'),
            ]
        );
    }

    /**
     * @Route("user/lieu_vie/edit/{id}", name="user_lieu_vie_edit")
     */
    public function edit(LieuVieEntity $lieuVie, Request $request)
    {
        $form = $this->createForm(LieuVieType::class, $lieuVie);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($lieuVie->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_lieu_vies');
        }

        return $this->render(
            'lieu_vie/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un lieu de vie',
                'baseEntity' => $lieuVie,
                'url_back'    => $this->generateUrl('user_lieu_vies'),
            ]
        );
    }
}
