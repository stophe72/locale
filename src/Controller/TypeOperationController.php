<?php

namespace App\Controller;

use App\Entity\TypeOperationEntity;
use App\Form\TypeOperationType;
use App\Repository\TypeOperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * Constructeur
     *
     * @param $session SessionInterface
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("user/typesoperation", name="user_typesoperation")
     */
    public function index(TypeOperationRepository $typeOperationRepository)
    {
        $tos = $typeOperationRepository->findBy([], ['libelle' => 'ASC']);

        return $this->render('type_operation/index.html.twig', [
            'page_title' => 'Liste des types d\'opération',
            'typeOperations' => $tos,
        ]);
    }
    /**
     * @Route("user/typeoperation/add", name="user_typeoperation_add")
     */
    public function add(Request $request)
    {
        $typeOperation = new TypeOperationEntity();

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

        $user = $this->security->getUser();

        if ($typeOperation->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
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
}
