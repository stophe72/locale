<?php

namespace App\Controller;

use App\Entity\LienExterneEntity;
use App\Form\LienExterneType;
use App\Repository\LienExterneRepository;
use App\Repository\MandataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class LienExterneController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var MandataireRepository
     */
    private $mandataireRepository;

    public function __construct(Security $security, MandataireRepository $mandataireRepository)
    {
        $this->security = $security;
        $this->mandataireRepository = $mandataireRepository;
    }

    private function getMandataire()
    {
        $user = $this->security->getUser();
        return $this->mandataireRepository->findOneBy(['user' => $user->getId()]);
    }

    private function isInSameGroupe(LienExterneEntity $lien)
    {
        return $lien && $this->getMandataire()->getGroupe() == $lien->getGroupe();
    }

    /**
     * Route non exposée, utilisée pour générer le menu dynamiquement à partir des liens en table
     */
    public function lienExternesMenu(LienExterneRepository $lienExterneRepository)
    {
        $mandataire = $this->getMandataire();
        $mandataire->getGroupe();
        $liens = $lienExterneRepository->findBy(
            [
                'groupe' => $this->getMandataire()->getGroupe(),
                'visible' => 1
            ],
            ['libelle' => 'ASC']
        );

        return $this->render(
            'lien_externe/liste_menu.html.twig',
            [
                'liens' => $liens,
            ]
        );
    }

    /**
     * @Route("user/lienexternes", name="user_lienexternes")
     */
    public function index(LienExterneRepository $lienExterneRepository)
    {
        $liens = $lienExterneRepository->findBy(['groupe' => $this->getMandataire()->getGroupe()], ['libelle' => 'ASC']);

        return $this->render('lien_externe/index.html.twig', [
            'lienExternes' => $liens,
            'page_title' => 'Liste des liens externes',
        ]);
    }

    /**
     * @Route("user/lienexterne/add", name="user_lienexterne_add")
     */
    public function add(Request $request)
    {
        $lien = new LienExterneEntity();
        $lien->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(LienExterneType::class, $lien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lien);
            $em->flush();

            return $this->redirectToRoute('user_lienexternes');
        }

        return $this->render(
            'lien_externe/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouveau lien externe',
                'baseEntity' => $lien,
                'url_back' => $this->generateUrl('user_lienexternes'),
            ]
        );
    }

    /**
     * @Route("user/lienexterne/edit/{id}", name="user_lienexterne_edit")
     */
    public function edit(LienExterneEntity $lien, Request $request)
    {
        $form = $this->createForm(LienExterneType::class, $lien);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($lien) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_lienexternes');
        }

        return $this->render(
            'lien_externe/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un lien externe',
                'baseEntity' => $lien,
                'url_back'    => $this->generateUrl('user_lienexternes'),
            ]
        );
    }

    /**
     * @Route("user/lienexterne/delete/{id}", name="user_lienexterne_delete")
     */
    public function delete(
        LienExterneEntity $lien,
        LienExterneRepository $lienExterneRepository
    ) {
        if ($lien) {
            $count = $lienExterneRepository->countById($this->getMandataire(), $lien->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($lien);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_lienexternes');
    }
}
