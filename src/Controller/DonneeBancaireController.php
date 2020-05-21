<?php

namespace App\Controller;

use App\Entity\DonneeBancaireEntity;
use App\Entity\MajeurEntity;
use App\Form\DonneeBancaireType;
use App\Repository\DonneeBancaireRepository;
use App\Repository\MandataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DonneeBancaireController extends AbstractController
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

    private function isInSameGroupe(DonneeBancaireEntity $donneeBancaire)
    {
        return $donneeBancaire && $this->getMandataire()->getGroupe() == $donneeBancaire->getMajeur()->getGroupe();
    }

    /**
     * @Route("user/donneebancaires/{majeur}", name="user_donneebancaires")
     */
    public function index(MajeurEntity $majeur, DonneeBancaireRepository $donneeBancaireRepository)
    {
        $dbs = $donneeBancaireRepository->findByMajeur($this->getMandataire(), $majeur);

        return $this->render('donnee_bancaire/index.html.twig', [
            'donneebancaires' => $dbs,
            'majeur' => $majeur,
            'page_title' => 'Liste des données bancaires',
        ]);
    }

    /**
     * @Route("user/donneebancaire/add/{majeur}", name="user_donneebancaire_add")
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

            return $this->redirectToRoute(
                'user_donneebancaires',
                [
                    'majeur' => $majeur->getId(),
                ]
            );
        }

        return $this->render('donnee_bancaire/new_or_edit.html.twig', [
            'page_title' => 'Ajouter une donnée bancaire',
            'form' => $form->createView(),
            'baseEntity' => $db,
            'url_back' => $this->generateUrl(
                'user_donneebancaires',
                [
                    'majeur' => $majeur->getId(),
                ]
            ),
        ]);
    }

    /**
     * @Route("user/donneebancaire/edit/{id}", name="user_donneebancaire_edit")
     */
    public function edit(DonneeBancaireEntity $donneeBancaire, Request $request)
    {
        $form = $this->createForm(DonneeBancaireType::class, $donneeBancaire);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($donneeBancaire) && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($donneeBancaire);
            $em->flush();

            return $this->redirectToRoute(
                'user_donneebancaires',
                [
                    'majeur' => $donneeBancaire->getMajeur()->getId(),
                ]
            );
        }

        return $this->render('donnee_bancaire/new_or_edit.html.twig', [
            'page_title' => 'Editer une donnée bancaire',
            'form' => $form->createView(),
            'baseEntity' => $donneeBancaire,
            'url_back' => $this->generateUrl(
                'user_donneebancaires',
                [
                    'majeur' => $donneeBancaire->getMajeur()->getId(),
                ]
            ),
        ]);
    }

    /**
     * @Route("user/donneebancaire/ajaxCanDeleteAgenceBancaire", name="ajaxCanDeleteDonneeBancaire")
     */
    public function ajaxCanDeleteAgenceBancaire(
        Request $request,
        DonneeBancaireRepository $donneeBancaireRepository
    ) {
        $donneeBancaireId = $request->get('donneebancaireId', -1);
        $count = $donneeBancaireRepository->countByCompteGestion($this->getMandataire(), $donneeBancaireId);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/donneebancaire/delete/{id}", name="user_donneebancaire_delete")
     */
    public function delete(
        DonneeBancaireEntity $donneeBancaire,
        DonneeBancaireRepository $donneeBancaireRepository
    ) {
        if ($this->isInSameGroupe($donneeBancaire)) {
            $count = $donneeBancaireRepository->countByCompteGestion($this->getMandataire(), $donneeBancaire->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($donneeBancaire);
                $em->flush();
            }
        }
        return $this->redirectToRoute(
            'user_donneebancaires',
            [
                'majeur' => $donneeBancaire->getMajeur()->getId(),
            ]
        );
    }
}
