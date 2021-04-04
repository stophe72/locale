<?php

namespace App\Controller;

use App\Entity\FicheFraisEntity;
use App\Entity\NoteDeFraisEntity;
use App\Form\FicheFraisType;
use App\Form\NoteDeFraisType;
use App\Repository\FicheFraisRepository;
use App\Repository\MandataireRepository;
use App\Repository\TypeFraisRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FicheFraisController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var Pdf
     */
    private $snappyPdf;

    /**
     * @var MandataireRepository
     */
    private $mandataireRepository;

    public function __construct(Security $security, Pdf $pdf, MandataireRepository $mandataireRepository)
    {
        $this->snappyPdf = $pdf;
        $this->security = $security;
        $this->mandataireRepository = $mandataireRepository;
    }

    private function isNoteOwnBy(NoteDeFraisEntity $noteDeFrais)
    {
        return $noteDeFrais && $this->getMandataire() == $noteDeFrais->getFicheFrais()->getMandataire();
    }

    private function getMandataire()
    {
        $user = $this->security->getUser();
        return $this->mandataireRepository->findOneBy(['user' => $user->getId()]);
    }

    /**
     * @Route("user/fichesdefrais", name="user_fichesdefrais")
     */
    public function index(FicheFraisRepository $ficheFraisRepository)
    {
        $ffs = $ficheFraisRepository->getAllByFiche($this->getMandataire());

        return $this->render('fiche_de_frais/index.html.twig', [
            'fichesDeFrais' => $ffs,
            'page_title' => "Liste des fiches de frais"
        ]);
    }

    /**
     * @Route("user/fichedefrais/addfiche", name="user_fichefrais_add_fiche")
     */
    public function addFiche(Request $request, MandataireRepository $mandataireRepository)
    {
        $ficheFrais = new FicheFraisEntity();
        $ficheFrais->setMandataire($this->getMandataire());

        $form = $this->createForm(FicheFraisType::class, $ficheFrais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ficheFrais);
            $em->flush();

            return $this->redirectToRoute('user_fichesdefrais');
        }
        return $this->render(
            'fiche_de_frais/fiche_frais_new_or_edit.html.twig',
            [
                'form'       => $form->createView(),
                'page_title' => 'Nouvelle fiche de frais',
                'baseEntity' => $ficheFrais,
                'url_back'   => $this->generateUrl('user_fichesdefrais'),
            ]
        );
    }

    /**
     * @Route("user/fichedefrais/editfiche/{ficheFrais}", name="user_fichefrais_edit_fiche")
     */
    public function editFiche(Request $request, FicheFraisEntity $ficheFrais, MandataireRepository $mandataireRepository)
    {
        $form = $this->createForm(FicheFraisType::class, $ficheFrais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_fichesdefrais');
        }
        return $this->render(
            'fiche_de_frais/fiche_frais_new_or_edit.html.twig',
            [
                'form'       => $form->createView(),
                'page_title' => 'Renommer la fiche de frais',
                'baseEntity' => $ficheFrais,
                'url_back'   => $this->generateUrl('user_fichesdefrais'),
            ]
        );
    }

    /**
     * @Route("user/fichedefrais/add/{ficheFrais}", name="user_fichefrais_add")
     */
    public function addNote(FicheFraisEntity $ficheFrais, Request $request, TypeFraisRepository $typeFraisRepository)
    {
        $noteDeFrais = new NoteDeFraisEntity();
        $noteDeFrais->setFicheFrais($ficheFrais);

        $typesFrais = $typeFraisRepository->findBy([], ['libelle' => 'ASC']);

        $form = $this->createForm(NoteDeFraisType::class, $noteDeFrais, ['typesFrais' => $typesFrais]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($noteDeFrais);
            $em->flush();

            return $this->redirectToRoute('user_fichesdefrais');
        }

        return $this->render(
            'fiche_de_frais/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouvelle note de frais',
                'baseEntity' => $noteDeFrais,
                'url_back' => $this->generateUrl('user_fichesdefrais'),
            ]
        );
    }

    /**
     * @Route("user/fichedefrais/edit/{id}", name="user_fichefrais_edit")
     */
    public function edit(
        NoteDeFraisEntity $noteDeFrais,
        Request $request,
        TypeFraisRepository $typeFraisRepository
    ) {
        $typesFrais = $typeFraisRepository->findBy([], ['libelle' => 'ASC']);

        $form = $this->createForm(NoteDeFraisType::class, $noteDeFrais, ['typesFrais' => $typesFrais]);
        $form->handleRequest($request);

        if ($this->isNoteOwnBy($noteDeFrais) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_fichesdefrais');
        }

        return $this->render(
            'fiche_de_frais/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Modifier une note de frais',
                'baseEntity' => $noteDeFrais,
                'url_back' => $this->generateUrl('user_fichesdefrais'),
            ]
        );
    }

    /**
     * @Route("user/fichedefrais/delete/{id}", name="user_fichefrais_delete")
     */
    public function delete(NoteDeFraisEntity $noteDeFrais)
    {
        if ($this->isNoteOwnBy($noteDeFrais)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($noteDeFrais);
            $em->flush();
        }
        return $this->redirectToRoute('user_fichesdefrais');
    }

    /**
     * @Route("user/fichedefrais/exporter/{ficheFrais}", name="user_fichefrais_export")
     */
    public function exporter(FicheFraisEntity $ficheFrais)
    {
        if (!$ficheFrais || $ficheFrais->getMandataire() != $this->getMandataire()) {
            return $this->redirectToRoute('user_fichesdefrais');
        }

        $html = $this->renderView(
            'fiche_de_frais/export.html.twig',
            [
                'page_title' => 'Fiche de frais',
                'fiche' => $ficheFrais,
            ]
        );

        return new PdfResponse(
            $this->snappyPdf->getOutputFromHtml($html),
            'fiche_frais_' . $ficheFrais->getId() . '.pdf'
        );
    }
}
