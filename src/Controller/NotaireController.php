<?php

namespace App\Controller;

use App\Entity\NotaireEntity;
use App\Form\NotaireType;
use App\Repository\MandataireRepository;
use App\Repository\NotaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class NotaireController extends AbstractController
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

    private function isInSameGroupe(NotaireEntity $notaire)
    {
        return $notaire && $this->getMandataire()->getGroupe() == $notaire->getGroupe();
    }

    /**
     * @Route("user/notaires", name="user_notaires")
     */
    public function index(NotaireRepository $notaireRepository)
    {
        return $this->render('notaire/index.html.twig', [
            'notaires' => $notaireRepository->findBy(['groupe' => $this->getMandataire()->getGroupe(),], ['libelle' => 'ASC']),
            'page_title' => 'Liste des notaires',
        ]);
    }

    /**
     * @Route("user/notaire/add", name="user_notaire_add")
     */
    public function add(Request $request)
    {
        $notaire = new NotaireEntity();
        $notaire->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(NotaireType::class, $notaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notaire);
            $em->flush();

            return $this->redirectToRoute('user_notaires');
        }

        return $this->render(
            'notaire/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouveau notaire',
                'baseEntity' => $notaire,
                'url_back' => $this->generateUrl('user_notaires'),
            ]
        );
    }

    /**
     * @Route("user/notaire/edit/{id}", name="user_notaire_edit")
     */
    public function edit(NotaireEntity $notaire, Request $request)
    {
        $form = $this->createForm(NotaireType::class, $notaire);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($notaire) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_notaires');
        }

        return $this->render(
            'notaire/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un notaire',
                'baseEntity' => $notaire,
                'url_back'    => $this->generateUrl('user_notaires'),
            ]
        );
    }

    /**
     * @Route("user/notaire/show/{id}", name="user_notaire_show")
     */
    public function show(NotaireEntity $notaire, Request $request)
    {
        if ($this->isInSameGroupe($notaire)) {
            return $this->render(
                'notaire/show.html.twig',
                [
                    'notaire' => $notaire,
                    'page_title' => 'Détails d\'un notaire',
                    'url_back'   => $this->generateUrl('user_notaires'),
                ]
            );
        }
        return $this->redirectToRoute('user_notaires');
    }

    /**
     * @Route("user/notaire/ajaxCanDeleteNotaire", name="ajaxCanDeleteNotaire")
     */
    public function ajaxCanDeleteNotaire(
        Request $request,
        NotaireRepository $notaireRepository
    ) {
        $pompeFunebreId = $request->get('pompeFunebreId', -1);
        $count = $notaireRepository->countById($this->getMandataire(), $pompeFunebreId);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/notaire/delete/{id}", name="user_notaire_delete")
     */
    public function delete(
        NotaireEntity $notaire,
        NotaireRepository $notaireRepository
    ) {
        if ($this->isInSameGroupe($notaire)) {
            $count = $notaireRepository->countById($this->getMandataire(), $notaire->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($notaire);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_notaires');
    }
}
