<?php

namespace App\Controller;

use App\Entity\FamilleTypeOperationEntity;
use App\Form\FamilleTypeOperationType;
use App\Repository\FamilleTypeOperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FamilleTypeOperationController extends AbstractController
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
     * @Route("user/familletypeoperations", name="user_familletypeoperations")
     */
    public function index(FamilleTypeOperationRepository $familleTypeOperationRepository)
    {
        $user = $this->security->getUser();

        return $this->render('famille_type_operation/index.html.twig', [
            'familleTypeOperations' => $familleTypeOperationRepository->findBy(['user' => $user->getId(),], ['libelle' => 'ASC']),
            'page_title' => 'Liste des familles de types d\'opération',
        ]);
    }

    /**
     * @Route("user/familletypeoperation/add", name="user_familletypeoperation_add")
     */
    public function add(Request $request)
    {
        $familleTypeOperation = new FamilleTypeOperationEntity();

        $form = $this->createForm(FamilleTypeOperationType::class, $familleTypeOperation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($familleTypeOperation);
            $em->flush();

            return $this->redirectToRoute('user_familletypeoperations');
        }

        return $this->render(
            'famille_type_operation/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouvelle famille de types d\'opération',
                'baseEntity' => $familleTypeOperation,
                'url_back' => $this->generateUrl('user_familletypeoperations'),
            ]
        );
    }

    /**
     * @Route("user/familletypeoperation/edit/{id}", name="user_familletypeoperation_edit")
     */
    public function edit(FamilleTypeOperationEntity $familleTypeOperation, Request $request, FamilleTypeOperationRepository $familleTypeOperationRepository)
    {
        $form = $this->createForm(FamilleTypeOperationType::class, $familleTypeOperation);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($familleTypeOperation->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_familletypeoperations');
        }

        return $this->render(
            'famille_type_operation/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une famille de types d\'opération',
                'baseEntity' => $familleTypeOperation,
                'url_back'    => $this->generateUrl('user_familletypeoperations'),
            ]
        );
    }

    /**
     * @Route("user/familletypeoperation/ajaxCanDeleteFamilleTypeOperation", name="ajaxCanDeleteFamilleTypeOperation")
     */
    public function ajaxCanDeleteFamilleTypeOperation(
        Request $request,
        FamilleTypeOperationRepository $familleTypeOperationRepository
    ) {
        $user = $this->security->getUser();

        $familleTypeOperationId = $request->get('familleTypeOperationId', -1);
        $count = $familleTypeOperationRepository->countById($user, $familleTypeOperationId);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/familletypeoperation/delete/{id}", name="user_familletypeoperation_delete")
     */
    public function delete(
        FamilleTypeOperationEntity $familleTypeOperation,
        FamilleTypeOperationRepository $familleTypeOperationRepository
    ) {
        if ($familleTypeOperation) {
            $user = $this->security->getUser();
            $count = $familleTypeOperationRepository->countById($user, $familleTypeOperation->getId());

            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($familleTypeOperation);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_familletypeoperations');
    }
}
