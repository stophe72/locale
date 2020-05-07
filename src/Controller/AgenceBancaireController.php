<?php

namespace App\Controller;

use App\Entity\AgenceBancaireEntity;
use App\Form\AgenceBancaireType;
use App\Repository\AgenceBancaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AgenceBancaireController extends AbstractController
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
     * @Route("user/agencebancaires", name="user_agencebancaires")
     */
    public function index(AgenceBancaireRepository $agenceBancaireRepository)
    {
        $user = $this->security->getUser();

        return $this->render('agence_bancaire/index.html.twig', [
            'banques' => $agenceBancaireRepository->findBy(['user' => $user->getId(),], ['libelle' => 'ASC']),
            'page_title' => 'Liste des agences bancaires',
        ]);
    }

    /**
     * @Route("user/agencebancaire/add", name="user_agencebancaire_add")
     */
    public function add(Request $request)
    {
        $agenceBancaire = new AgenceBancaireEntity();

        $form = $this->createForm(AgenceBancaireType::class, $agenceBancaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agenceBancaire);
            $em->flush();

            return $this->redirectToRoute('user_agencebancaires');
        }

        return $this->render(
            'agence_bancaire/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouvelle agence bancaire',
                'baseEntity' => $agenceBancaire,
                'url_back' => $this->generateUrl('user_agencebancaires'),
            ]
        );
    }

    /**
     * @Route("user/agencebancaire/edit/{id}", name="user_agencebancaire_edit")
     */
    public function edit(AgenceBancaireEntity $agenceBancaire, Request $request)
    {
        $form = $this->createForm(AgenceBancaireType::class, $agenceBancaire);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($agenceBancaire->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_agencebancaires');
        }

        return $this->render(
            'agence_bancaire/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une agence bancaire',
                'baseEntity' => $agenceBancaire,
                'url_back'    => $this->generateUrl('user_agencebancaires'),
            ]
        );
    }

    /**
     * @Route("user/agencebancaire/ajaxCanDeleteAgenceBancaire", name="ajaxCanDeleteAgenceBancaire")
     */
    public function ajaxCanDeleteAgenceBancaire(
        Request $request,
        AgenceBancaireRepository $agenceBancaireRepository
    ) {
        $user = $this->security->getUser();

        $agenceId = $request->get('agenceId', -1);
        $count = $agenceBancaireRepository->countByDonneeBancaire($user, $agenceId);

        return new JsonResponse(['data' => $count == 0]);
    }


    /**
     * @Route("user/agenceBancaire/delete/{id}", name="user_agencebancaire_delete")
     */
    public function delete(
        AgenceBancaireEntity $agenceBancaire,
        AgenceBancaireRepository $agenceBancaireRepository
    ) {
        $user = $this->security->getUser();

        if ($agenceBancaire) {
            $count = $agenceBancaireRepository->countByDonneeBancaire($user, $agenceBancaire->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($agenceBancaire);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_visites');
    }
}
