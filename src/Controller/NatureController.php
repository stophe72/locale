<?php

namespace App\Controller;

use App\Entity\NatureEntity;
use App\Form\NatureType;
use App\Repository\NatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class NatureController extends AbstractController
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
     * @Route("user/natures", name="user_natures")
     */
    public function index(NatureRepository $natureRepository)
    {
        return $this->render('nature/index.html.twig', [
            'natures' => $natureRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des natures de mission',
        ]);
    }

    /**
     * @Route("user/nature/add", name="user_nature_add")
     */
    public function add(Request $request)
    {
        $nature = new NatureEntity();

        $form = $this->createForm(NatureType::class, $nature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($nature);
            $em->flush();

            return $this->redirectToRoute('user_natures');
        }

        return $this->render(
            'nature/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle nature de mission',
                'baseEntity' => $nature,
                'url_back'    => 'user_natures',
            ]
        );
    }

    /**
     * @Route("user/nature/edit/{id}", name="user_nature_edit")
     */
    public function edit(NatureEntity $nature, Request $request)
    {
        $form = $this->createForm(NatureType::class, $nature);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($nature->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_natures');
        }

        return $this->render(
            'nature/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une nature de mission',
                'baseEntity' => $nature,
                'url_back'    => 'user_natures',
            ]
        );
    }
}
