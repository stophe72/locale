<?php

namespace App\Controller;

use App\Entity\FamilleCompteEntity;
use App\Form\FamilleCompteType;
use App\Repository\FamilleCompteRepository;
use App\Repository\MandataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    private function isInSameGroupe(FamilleCompteEntity $familleCompte)
    {
        return $familleCompte && $this->getMandataire()->getGroupe() == $familleCompte->getGroupe();
    }

    /**
     * @Route("user/famillecomptes", name="user_famillecomptes")
     */
    public function index(FamilleCompteRepository $familleCompteRepository)
    {
        return $this->render('famille_compte/index.html.twig', [
            'familleComptes' => $familleCompteRepository->findBy(['groupe' => $this->getMandataire()->getGroupe(),], ['libelle' => 'ASC']),
            'page_title' => 'Liste des familles de comptes',
        ]);
    }

    /**
     * @Route("user/famillecompte/add", name="user_famillecompte_add")
     */
    public function add(Request $request)
    {
        $familleCompte = new FamilleCompteEntity();
        $familleCompte->setGroupe($this->getMandataire()->getGroupe());

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
    public function edit(FamillecompteEntity $familleCompte, Request $request)
    {
        $form = $this->createForm(FamilleCompteType::class, $familleCompte);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($familleCompte) && $form->isSubmitted() && $form->isValid()) {
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

    /**
     * @Route("user/famillecompte/ajaxCanDeleteAgenceBancaire", name="ajaxCanDeleteFamilleCompte")
     */
    public function ajaxCanDeleteFamilleCompte(
        Request $request,
        FamilleCompteRepository $familleCompteRepository
    ) {
        $familleCompte = $request->get('familleCompteId', -1);
        $count = $familleCompteRepository->countById($this->getMandataire(), $familleCompte);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/famillecompte/delete/{id}", name="user_famillecompte_delete")
     */
    public function delete(
        FamilleCompteEntity $familleCompte,
        FamilleCompteRepository $familleCompteRepository
    ) {
        if ($familleCompte) {
            $count = $familleCompteRepository->countById($this->getMandataire(), $familleCompte->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($familleCompte);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_famillecomptes');
    }
}
