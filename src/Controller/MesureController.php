<?php

namespace App\Controller;

use App\Entity\MesureEntity;
use App\Form\MesureType;
use App\Repository\MandataireRepository;
use App\Repository\MesureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MesureController extends AbstractController
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

    private function isInSameGroupe(MesureEntity $mesure)
    {
        return $mesure && $this->getMandataire()->getGroupe() == $mesure->getGroupe();
    }

    /**
     * @Route("user/mesures", name="user_mesures")
     */
    public function index(MesureRepository $mesureRepository)
    {
        return $this->render('mesure/index.html.twig', [
            'mesures' => $mesureRepository->findBy(['groupe' => $this->getMandataire()->getGroupe()], ['libelle' => 'ASC']),
            'page_title' => 'Liste des mesures',
        ]);
    }

    /**
     * @Route("user/mesure/add", name="user_mesure_add")
     */
    public function add(Request $request)
    {
        $mesure = new MesureEntity();
        $mesure->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(MesureType::class, $mesure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mesure);
            $em->flush();

            return $this->redirectToRoute('user_mesures');
        }

        return $this->render(
            'mesure/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle mesure de mission',
                'baseEntity' => $mesure,
                'url_back'    => $this->generateUrl('user_mesures'),
            ]
        );
    }

    /**
     * @Route("user/mesure/edit/{id}", name="user_mesure_edit")
     */
    public function edit(MesureEntity $mesure, Request $request)
    {
        $form = $this->createForm(MesureType::class, $mesure);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($mesure) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_mesures');
        }

        return $this->render(
            'mesure/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une mesure de mission',
                'baseEntity' => $mesure,
                'url_back'    => $this->generateUrl('user_mesures'),
            ]
        );
    }

    /**
     * @Route("user/mesure/ajaxCanDeleteMesure", name="ajaxCanDeleteMesure")
     */
    public function ajaxCanDeleteMesure(
        Request $request,
        MesureRepository $mesureRepository
    ) {
        $mesureId = $request->get('mesureId', -1);
        $count = $mesureRepository->countById($this->getMandataire(), $mesureId);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/mesure/delete/{id}", name="user_mesure_delete")
     */
    public function delete(
        MesureEntity $mesure,
        MesureRepository $mesureRepository
    ) {
        if ($mesure) {
            $count = $mesureRepository->countById($this->getMandataire(), $mesure->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($mesure);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_mesures');
    }
}
