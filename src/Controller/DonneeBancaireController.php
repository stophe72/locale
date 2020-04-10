<?php

namespace App\Controller;

use App\Entity\DonneeBancaireEntity;
use App\Entity\MajeurEntity;
use App\Form\DonneeBancaireType;
use App\Repository\MajeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DonneeBancaireController extends AbstractController
{
    /**
     * @Route("/donnee/bancaire", name="donnee_bancaire")
     */
    public function index()
    {
        return $this->render('donnee_bancaire/index.html.twig', [
            'controller_name' => 'DonneeBancaireController',
        ]);
    }

    /**
     * @Route("user/donneebancaire/add/{id}", name="user_donneebancaire_add")
     */
    public function add(MajeurEntity $majeur, Request $request)
    {
        $db = new DonneeBancaireEntity();
        $db->setMajeur($majeur);

        $form = $this->createForm(DonneeBancaireType::class, $db);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($db);
            $em->flush();

            return $this->redirectToRoute('user_majeur_show', ['id' => $majeur->getId(),]);
        }

        return $this->render('donnee_bancaire/new_or_edit.html.twig', [
            'page_title' => 'Données bancaires',
            'form' => $form->createView(),
            'baseEntity' => $db,
            'url_back' => 'user_majeurs',
        ]);
    }
}
