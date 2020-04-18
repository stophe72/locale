<?php

namespace App\Controller;

use App\Entity\NatureOperationEntity;
use App\Form\NatureOperationType;
use App\Repository\NatureOperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class NatureOperationController extends AbstractController
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
     * @Route("user/natureoperations", name="user_naturesoperation")
     */
    public function index(NatureOperationRepository $natureOperationRepository)
    {
        return $this->render('nature_operation/index.html.twig', [
            'naturesOperation' => $natureOperationRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des natures d\'opération',
        ]);
    }

    /**
     * @Route("user/natureoperation/add", name="user_natureoperation_add")
     */
    public function add(Request $request)
    {
        $nature = new NatureOperationEntity();

        $form = $this->createForm(NatureOperationType::class, $nature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($nature);
            $em->flush();

            return $this->redirectToRoute('user_naturesoperation');
        }

        return $this->render(
            'nature_operation/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle nature d\'operation',
                'baseEntity' => $nature,
                'url_back'    => $this->generateUrl('user_naturesoperation'),
            ]
        );
    }

    /**
     * @Route("user/natureoperation/edit/{id}", name="user_natureoperation_edit")
     */
    public function edit(NatureOperationEntity $nature, Request $request)
    {
        $form = $this->createForm(NatureOperationType::class, $nature);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($nature->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_naturesoperation');
        }

        return $this->render(
            'nature_operation/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une nature d\'opération',
                'baseEntity' => $nature,
                'url_back'    => $this->generateUrl('user_naturesoperation'),
            ]
        );
    }
}
