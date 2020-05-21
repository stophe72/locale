<?php

namespace App\Controller;

use App\Entity\ImportOperationEntity;
use App\Form\ImportOperationType;
use App\Repository\ImportOperationRepository;
use App\Repository\MandataireRepository;
use App\Repository\TypeOperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ImportOperationController extends AbstractController
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

    private function isInSameGroupe(ImportOperationEntity $importOperation)
    {
        return $importOperation && $this->getMandataire()->getGroupe() == $importOperation->getGroupe();
    }

    /**
     * @Route("user/importoperations", name="user_importoperations")
     */
    public function index(ImportOperationRepository $importOperationRepository)
    {
        $ios = $importOperationRepository->findByGroupe($this->getMandataire());
        return $this->render(
            'import_operation/index.html.twig',
            [
                'page_title' => 'Liste des imports opération',
                'importsOperation' => $ios,
            ]
        );
    }

    /**
     * @Route("user/importoperation/add", name="user_importoperation_add")
     */
    public function add(Request $request, TypeOperationRepository $typeOperationRepository)
    {
        $tos = $typeOperationRepository->findBy(['groupe' => $this->getMandataire()->getGroupe(),], ['libelle' => 'ASC',]);
        $importOperation = new ImportOperationEntity();
        $importOperation->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(
            ImportOperationType::class,
            $importOperation,
            ['typesOperation' => $tos,]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($importOperation);
            $em->flush();

            return $this->redirectToRoute('user_importoperations');
        }

        return $this->render(
            'import_operation/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvel import d\'opération',
                'baseEntity' => $importOperation,
                'url_back'    => $this->generateUrl('user_importoperations'),
            ]
        );
    }

    /**
     * @Route("user/importoperation/edit/{id}", name="user_importoperation_edit")
     */
    public function edit(ImportOperationEntity $importOperation, Request $request, TypeOperationRepository $typeOperationRepository)
    {
        $tos = $typeOperationRepository->findBy(['groupe' => $this->getMandataire()->getGroupe(),], ['libelle' => 'ASC',]);

        $form = $this->createForm(
            ImportOperationType::class,
            $importOperation,
            ['typesOperation' => $tos,]
        );
        $form->handleRequest($request);

        if ($this->isInSameGroupe($importOperation) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_importoperations');
        }

        return $this->render(
            'import_operation/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une import d\'opération',
                'baseEntity' => $importOperation,
                'url_back'    => $this->generateUrl('user_importoperations'),
            ]
        );
    }

    /**
     * @Route("user/importoperation/delete/{id}", name="user_importoperation_delete")
     */
    public function delete(ImportOperationEntity $importOperation)
    {
        if ($this->isInSameGroupe($importOperation)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($importOperation);
            $em->flush();
        }
        return $this->redirectToRoute('user_importoperations');
    }
}
