<?php

namespace App\Controller;

use App\Entity\TypeCompteEntity;
use App\Form\TypeCompteType;
use App\Repository\MandataireRepository;
use App\Repository\TypeCompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TypeCompteController extends AbstractController
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

    private function isInSameGroupe(TypeCompteEntity $typeCompte)
    {
        return $typeCompte && $this->getMandataire()->getGroupe() == $typeCompte->getGroupe();
    }

    /**
     * @Route("user/typecomptes", name="user_typecomptes")
     */
    public function index(TypeCompteRepository $typeCompteRepository)
    {
        return $this->render('type_compte/index.html.twig', [
            'typeComptes' => $typeCompteRepository->findBy(['groupe' => $this->getMandataire()->getGroupe()], ['libelle' => 'ASC']),
            'page_title' => 'Liste des types de compte',
        ]);
    }

    /**
     * @Route("user/typecompte/add", name="user_typecompte_add")
     */
    public function add(Request $request)
    {
        $typeCompte = new TypeCompteEntity();
        $typeCompte->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(TypeCompteType::class, $typeCompte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeCompte);
            $em->flush();

            return $this->redirectToRoute('user_typecomptes');
        }

        return $this->render(
            'type_compte/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouveau type de compte',
                'baseEntity' => $typeCompte,
                'url_back'    => $this->generateUrl('user_typecomptes'),
            ]
        );
    }

    /**
     * @Route("user/typecompte/edit/{id}", name="user_typecompte_edit")
     */
    public function edit(TypeCompteEntity $typeCompte, Request $request)
    {
        $form = $this->createForm(TypeCompteType::class, $typeCompte);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($typeCompte) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_typecomptes');
        }

        return $this->render(
            'type_compte/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un type de compte',
                'baseEntity' => $typeCompte,
                'url_back'    => $this->generateUrl('user_typecomptes'),
            ]
        );
    }

    /**
     * @Route("user/typecompte/ajaxCanDeleteTypeCompte", name="ajaxCanDeleteTypeCompte")
     */
    public function ajaxCanDeleteTypeCompte(
        Request $request,
        TypeCompteRepository $typeCompteRepository
    ) {
        $typeCompte = $request->get('typeCompteId', -1);
        $count = $typeCompteRepository->countById($this->getMandataire(), $typeCompte);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/typecompte/delete/{id}", name="user_typecompte_delete")
     */
    public function delete(
        TypeCompteEntity $typeCompte,
        TypeCompteRepository $typeCompteRepository
    ) {
        if ($typeCompte) {
            $count = $typeCompteRepository->countById($this->getMandataire(), $typeCompte->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($typeCompte);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_typecomptes');
    }
}
