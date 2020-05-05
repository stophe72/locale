<?php

namespace App\Controller;

use App\Entity\FicheFraisEntity;
use App\Entity\NoteDeFraisEntity;
use App\Form\NoteDeFraisType;
use App\Repository\FicheFraisRepository;
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

    private $snappyPdf;

    public function __construct(Security $security, Pdf $pdf)
    {
        $this->snappyPdf = $pdf;
        $this->security = $security;
    }

    /**
     * @Route("user/fichesdefrais", name="user_fichesdefrais")
     */
    public function index(
        FicheFraisRepository $ficheFraisRepository
    ) {
        $user = $this->security->getUser();
        $ffs = $ficheFraisRepository->getAllByFiche($user);

        return $this->render('fiche_de_frais/index.html.twig', [
            'fichesDeFrais' => $ffs,
            'page_title' => "Liste des fiches de frais"
        ]);
    }

    /**
     * @Route("user/fichedefrais/addfiche", name="user_fichefrais_add_fiche")
     */
    public function addFiche(Request $request, FicheFraisRepository $ficheFraisRepository)
    {
        $ficheFrais = new FicheFraisEntity;

        $em = $this->getDoctrine()->getManager();
        $em->persist($ficheFrais);
        $em->flush();

        $this->addFlash('success', 'Nouvelle fiche de frais créée');

        return $this->redirectToRoute('user_fichesdefrais');
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

        $user = $this->security->getUser();

        if ($noteDeFrais->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
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
    public function delete(
        NoteDeFraisEntity $noteDeFrais
    ) {
        $user = $this->security->getUser();
        if ($noteDeFrais && $noteDeFrais->isOwnBy($user)) {
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
