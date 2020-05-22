<?php

namespace App\Controller;

use App\Entity\LieuVieEntity;
use App\Form\LieuVieType;
use App\Repository\LieuVieRepository;
use App\Repository\MandataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class LieuVieController extends AbstractController
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

    private function isInSameGroupe(LieuVieEntity $lieuVie)
    {
        return $lieuVie && $this->getMandataire()->getGroupe() == $lieuVie->getGroupe();
    }

    /**
     * @Route("user/lieu_vies", name="user_lieu_vies")
     */
    public function index(LieuVieRepository $lieuVieRepository)
    {
        return $this->render('lieu_vie/index.html.twig', [
            'lieuVies' => $lieuVieRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des lieux de vie',
        ]);
    }

    /**
     * @Route("user/lieu_vie/add", name="user_lieu_vie_add")
     */
    public function add(Request $request)
    {
        $lieuVie = new LieuVieEntity();
        $lieuVie->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(LieuVieType::class, $lieuVie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lieuVie);
            $em->flush();

            return $this->redirectToRoute('user_lieu_vies');
        }

        return $this->render(
            'lieu_vie/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouveau lieu de vie',
                'baseEntity' => $lieuVie,
                'url_back'    => $this->generateUrl('user_lieu_vies'),
            ]
        );
    }

    /**
     * @Route("user/lieu_vie/edit/{id}", name="user_lieu_vie_edit")
     */
    public function edit(LieuVieEntity $lieuVie, Request $request)
    {
        $form = $this->createForm(LieuVieType::class, $lieuVie);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($lieuVie) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_lieu_vies');
        }

        return $this->render(
            'lieu_vie/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un lieu de vie',
                'baseEntity' => $lieuVie,
                'url_back'    => $this->generateUrl('user_lieu_vies'),
            ]
        );
    }

    /**
     * @Route("user/lieuvie/ajaxCanDeletelieuvie", name="ajaxCanDeleteLieuVie")
     */
    public function ajaxCanDeleteLieuVie(
        Request $request,
        LieuVieRepository $lieuVieRepository
    ) {
        $lieuVieId = $request->get('lieuVieId', -1);
        $count = $lieuVieRepository->countById($this->getMandataire(), $lieuVieId);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/lieuvie/delete/{id}", name="user_lieuvie_delete")
     */
    public function delete(
        LieuVieEntity $lieuvie,
        LieuVieRepository $lieuVieRepository
    ) {
        if ($lieuvie) {
            $count = $lieuVieRepository->countById($this->getMandataire(), $lieuvie->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($lieuvie);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_lieu_vies');
    }
}
