<?php

namespace App\Controller;

use App\Entity\TypeOperationEntity;
use App\Form\TypeOperationType;
use App\Repository\MandataireRepository;
use App\Repository\TypeOperationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TypeOperationController extends AbstractController
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

    private function isInSameGroupe(TypeOperationEntity $typeOperation)
    {
        return $typeOperation && $this->getMandataire()->getGroupe() == $typeOperation->getGroupe();
    }

    /**
     * @Route("user/typesoperation", name="user_typesoperation")
     */
    public function index(
        Request $request,
        TypeOperationRepository $typeOperationRepository,
        PaginatorInterface $paginator
    ) {
        $pagination = $paginator->paginate(
            $typeOperationRepository->getQueryBuilder($this->getMandataire()),
            $request->get('page', 1),
            12,
            [
                'defaultSortFieldName' => 'ope.libelle',
                'defaultSortDirection' => 'ASC'
            ]
        );

        return $this->render('type_operation/index.html.twig', [
            'page_title' => 'Liste des types d\'opération',
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("user/typeoperation/add", name="user_typeoperation_add")
     */
    public function add(Request $request)
    {
        $typeOperation = new TypeOperationEntity();
        $typeOperation->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(TypeOperationType::class, $typeOperation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeOperation);
            $em->flush();

            return $this->redirectToRoute('user_typesoperation');
        }

        return $this->render(
            'type_operation/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouveau type d\'opération',
                'baseEntity' => $typeOperation,
                'url_back'    => $this->generateUrl('user_typesoperation'),
            ]
        );
    }

    /**
     * @Route("user/typeOperation/edit/{id}", name="user_typeoperation_edit")
     */
    public function edit(TypeOperationEntity $typeOperation, Request $request)
    {
        $form = $this->createForm(TypeOperationType::class, $typeOperation);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($typeOperation) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_typesoperation');
        }

        return $this->render(
            'type_operation/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un type d\'opération',
                'baseEntity' => $typeOperation,
                'url_back'    => $this->generateUrl('user_typesoperation'),
            ]
        );
    }

    /**
     * @Route("user/typeoperation/ajaxCanDeleteTypeOperation", name="ajaxCanDeleteTypeOperation")
     */
    public function ajaxCanDeleteTypeOperation(
        Request $request,
        TypeOperationRepository $typeOperationRepository
    ) {
        $typeOperationId = $request->get('typeOperationId', -1);
        $mandataire = $this->getMandataire();
        $count = $typeOperationRepository->countByCompteGestion($mandataire, $typeOperationId)
            + $typeOperationRepository->countByImportOperation($mandataire, $typeOperationId);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/typeoperation/delete/{id}", name="user_typeoperation_delete")
     */
    public function delete(
        TypeOperationEntity $typeOperation,
        TypeOperationRepository $typeOperationRepository
    ) {
        if ($typeOperation) {
            $mandataire = $this->getMandataire();
            $count = $typeOperationRepository->countByCompteGestion($mandataire, $typeOperation->getId())
                + $typeOperationRepository->countByImportOperation($mandataire, $typeOperation->getId());

            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($typeOperation);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_typesoperation');
    }
}
