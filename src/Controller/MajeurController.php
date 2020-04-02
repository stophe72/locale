<?php

namespace App\Controller;

use App\Entity\MajeurEntity;
use App\Form\MajeurType;
use App\Repository\MajeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MajeurController extends AbstractController
{
    /**
     * @Route("user/majeurs", name="user_majeurs")
     */
    public function index(MajeurRepository $majeurRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('majeur/index.html.twig', [
            'majeurs' => $majeurRepository->findBy([], ['nom' => 'ASC']),
            'page_title' => 'Liste des majeurs',
        ]);
    }

    /**
     * @Route("user/majeur/add", name="user_majeur_add")
     */
    public function add(Request $request, MajeurRepository $majeurRepository)
    {
        $majeur = new MajeurEntity();

        $form = $this->createForm(MajeurType::class, $majeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($majeur);
            $em->flush();

            return $this->redirectToRoute('user_majeurs');
        }

        return $this->render(
            'majeur/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouveau majeur',
                'baseEntity' => $majeur,
                'url_back'    => 'user_majeurs',
            ]
        );
    }

    /**
     * @Route("user/majeur/edit/{id}", name="user_majeur_edit")
     */
    public function edit(MajeurRepository $majeurRepository)
    {
        return $this->render('majeur/index.html.twig', [
            'majeurs' => $majeurRepository->findBy([], ['nom' => 'ASC']),
            'page_title' => 'Liste des majeurs',
        ]);
    }
}
