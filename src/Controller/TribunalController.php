<?php

namespace App\Controller;

use App\Entity\TribunalEntity;
use App\Form\TribunalType;
use App\Repository\MandataireRepository;
use App\Repository\TribunalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TribunalController extends AbstractController
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

    private function isInSameGroupe(TribunalEntity $tribunal)
    {
        return $tribunal && $this->getMandataire()->getGroupe() == $tribunal->getGroupe();
    }

    /**
     * @Route("user/tribunaux", name="user_tribunaux")
     */
    public function index(TribunalRepository $tribunalRepository)
    {
        return $this->render('tribunal/index.html.twig', [
            'tribunaux' => $tribunalRepository->findBy(['groupe' => $this->getMandataire()->getGroupe()], ['libelle' => 'ASC']),
            'page_title' => 'Liste des tribunaux',
        ]);
    }

    /**
     * @Route("user/tribunal/add", name="user_tribunal_add")
     */
    public function add(Request $request)
    {
        $tribunal = new TribunalEntity();
        $tribunal->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(TribunalType::class, $tribunal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tribunal);
            $em->flush();

            return $this->redirectToRoute('user_tribunaux');
        }

        return $this->render(
            'tribunal/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouveau tribunal',
                'baseEntity' => $tribunal,
                'url_back'    => $this->generateUrl('user_tribunaux'),
            ]
        );
    }

    /**
     * @Route("user/tribunal/edit/{id}", name="user_tribunal_edit")
     */
    public function edit(TribunalEntity $tribunal, Request $request)
    {
        $form = $this->createForm(TribunalType::class, $tribunal);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($tribunal) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_tribunaux');
        }

        return $this->render(
            'tribunal/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un tribunal',
                'baseEntity' => $tribunal,
                'url_back'    => $this->generateUrl('user_tribunaux'),
            ]
        );
    }

    /**
     * @Route("user/tribunal/ajaxCanDeleteTribunal", name="ajaxCanDeleteTribunal")
     */
    public function ajaxCanDeleteTribunal(
        Request $request,
        TribunalRepository $tribunalRepository
    ) {
        $tribunalId = $request->get('tribunalId', -1);
        $count = $tribunalRepository->countByJugement($this->getMandataire(), $tribunalId);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/tribunal/delete/{id}", name="user_tribunal_delete")
     */
    public function delete(
        TribunalEntity $tribunal,
        TribunalRepository $tribunalRepository
    ) {
        if ($tribunal) {
            $count = $tribunalRepository->countByJugement($this->getMandataire(), $tribunal->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($tribunal);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_tribunaux');
    }
}
