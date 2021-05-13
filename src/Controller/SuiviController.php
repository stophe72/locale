<?php

namespace App\Controller;

use App\Entity\MajeurEntity;
use App\Entity\SuiviEntity;
use App\Form\SuiviType;
use App\Repository\MandataireRepository;
use App\Repository\SuiviRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class SuiviController extends AbstractController
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var MandataireRepository
     */
    private $mandataireRepository;

    public function __construct(
        SessionInterface $session,
        Security $security,
        MandataireRepository $mandataireRepository
    ) {
        $this->session = $session;
        $this->security = $security;
        $this->mandataireRepository = $mandataireRepository;
    }

    private function getMandataire()
    {
        /** @var $user UserInterface */
        $user = $this->security->getUser();
        return $this->mandataireRepository->findOneBy([
            'user' => $user->getId(),
        ]);
    }

    private function isInSameGroupe(MajeurEntity $majeurEntity)
    {
        return $majeurEntity &&
            $this->getMandataire()->getGroupe() == $majeurEntity->getGroupe();
    }

    /**
     * @Route("/user/majeur/suivi/{slug}", name="user_majeur_suivi")
     */
    public function index(
        MajeurEntity $majeur,
        SuiviRepository $suiviRepository
    ): Response {
        if (!$this->isInSameGroupe($majeur)) {
            return $this->redirectToRoute('user_majeurs');
        }
        $suivis = $suiviRepository->findBy(['majeur' => $majeur->getId()], ['dateCreation' => 'DESC']);

        return $this->render('suivi/index.html.twig', [
            'page_title' => 'Suivi - ' . $majeur->__toString(),
            'suivis'     => $suivis,
            'majeur'     => $majeur,
            'url_back'   => $this->generateUrl('user_majeurs'),
        ]);
    }

    /**
     * @Route("/user/suivi/add/{id}", name="user_suivi_add")
     */
    public function add(Request $request, MajeurEntity $majeur): Response
    {
        if (!$this->isInSameGroupe($majeur)) {
            return $this->redirectToRoute('user_majeurs');
        }
        $suivi = new SuiviEntity();
        $suivi->setMajeur($majeur);
        $suivi->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(SuiviType::class, $suivi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suivi);
            $em->flush();

            return $this->redirectToRoute('user_majeur_suivi', [
                'slug' => $majeur->getSlug(),
            ]);
        }

        return $this->render('suivi/new_or_edit.html.twig', [
            'form' => $form->createView(),
            'page_title' => 'Nouveau suivi - ' . $majeur->__toString(),
            'baseEntity' => $suivi,
            'url_back' => $this->generateUrl('user_majeur_suivi', [
                'slug' => $suivi->getMajeur()->getSlug(),
            ]),
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="user_suivi_edit")
     */
    public function edit(SuiviEntity $suivi, Request $request): Response
    {
        $majeur = $suivi->getMajeur();
        if (!$this->isInSameGroupe($majeur)) {
            return $this->redirectToRoute('user_majeurs');
        }
        $form = $this->createForm(SuiviType::class, $suivi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suivi);
            $em->flush();

            return $this->redirectToRoute('user_majeur_suivi', [
                'slug' => $majeur->getSlug(),
            ]);
        }

        return $this->render('suivi/new_or_edit.html.twig', [
            'form' => $form->createView(),
            'page_title' => 'Nouvelle note - ' . $majeur->__toString(),
            'baseEntity' => $suivi,
            'url_back' => $this->generateUrl('user_majeur_suivi', [
                'slug' => $suivi->getMajeur()->getSlug(),
            ]),
        ]);
    }

    /**
     * @Route("/user/suivi/delete/{id}", name="user_suivi_delete")
     */
    public function delete(SuiviEntity $suivi): Response
    {
        if ($suivi) {
            if ($this->isInSameGroupe($suivi->getMajeur())) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($suivi);
                $em->flush();
            }
            return $this->redirectToRoute('user_majeur_suivi', [
                'slug' => $suivi->getMajeur()->getSlug(),
            ]);
        }
        return $this->redirectToRoute('user_majeurs');
    }
}
