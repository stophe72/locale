<?php

namespace App\Controller;

use App\Entity\PompeFunebreEntity;
use App\Form\PompeFunebreType;
use App\Repository\MandataireRepository;
use App\Repository\PompeFunebreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PompeFunebreController extends AbstractController
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

    private function isInSameGroupe(PompeFunebreEntity $pompeFunebre)
    {
        return $pompeFunebre && $this->getMandataire()->getGroupe() == $pompeFunebre->getGroupe();
    }

    /**
     * @Route("user/pompefunebres", name="user_pompefunebres")
     */
    public function index(PompeFunebreRepository $pompeFunebreRepository)
    {
        return $this->render('pompe_funebre/index.html.twig', [
            'pompeFunebres' => $pompeFunebreRepository->findBy(['groupe' => $this->getMandataire()->getGroupe(),], ['libelle' => 'ASC']),
            'page_title' => 'Liste des pompes funèbres',
        ]);
    }

    /**
     * @Route("user/pompefunebre/add", name="user_pompefunebre_add")
     */
    public function add(Request $request)
    {
        $pompeFunebre = new PompeFunebreEntity();
        $pompeFunebre->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(PompeFunebreType::class, $pompeFunebre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pompeFunebre);
            $em->flush();

            return $this->redirectToRoute('user_pompefunebres');
        }

        return $this->render(
            'pompe_funebre/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouvelle pompe funèbre',
                'baseEntity' => $pompeFunebre,
                'url_back' => $this->generateUrl('user_pompefunebres'),
            ]
        );
    }

    /**
     * @Route("user/pompefunebre/edit/{id}", name="user_pompefunebre_edit")
     */
    public function edit(PompeFunebreEntity $pompeFunebre, Request $request)
    {
        $form = $this->createForm(PompeFunebreType::class, $pompeFunebre);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($pompeFunebre) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_pompefunebres');
        }

        return $this->render(
            'pompe_funebre/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une pompe funèbre',
                'baseEntity' => $pompeFunebre,
                'url_back'    => $this->generateUrl('user_pompefunebres'),
            ]
        );
    }

    /**
     * @Route("user/pompefunebre/show/{id}", name="user_pompefunebre_show")
     */
    public function show(PompeFunebreEntity $pompeFunebre, Request $request)
    {
        if ($this->isInSameGroupe($pompeFunebre)) {
            return $this->render(
                'pompe_funebre/show.html.twig',
                [
                    'pompeFunebre' => $pompeFunebre,
                    'page_title' => 'Détails d\'une pompe funèbre',
                    'url_back'   => $this->generateUrl('user_pompefunebres'),
                ]
            );
        }
        return $this->redirectToRoute('user_pompefunebres');
    }

    /**
     * @Route("user/pompefunebre/ajaxCanDeletePompeFunebre", name="ajaxCanDeletePompeFunebre")
     */
    public function ajaxCanDeletePompeFunebre(
        Request $request,
        PompeFunebreRepository $pompeFunebreRepository
    ) {
        $pompeFunebreId = $request->get('pompeFunebreId', -1);
        $count = $pompeFunebreRepository->countById($this->getMandataire(), $pompeFunebreId);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/pompefunebre/delete/{id}", name="user_pompefunebre_delete")
     */
    public function delete(
        PompeFunebreEntity $pompeFunebre,
        PompeFunebreRepository $pompeFunebreRepository
    ) {
        if ($this->isInSameGroupe($pompeFunebre)) {
            $count = $pompeFunebreRepository->countById($this->getMandataire(), $pompeFunebre->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($pompeFunebre);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_pompefunebres');
    }
}
