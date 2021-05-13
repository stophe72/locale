<?php

namespace App\Controller;

use App\Entity\MajeurEntity;
use App\Repository\CompteGestionRepository;
use App\Repository\JugementRepository;
use App\Repository\MajeurRepository;
use App\Repository\MandataireRepository;
use App\Repository\ParametreMissionRepository;
use DateTime;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class RapportController extends AbstractController
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

    public function __construct(
        Security $security,
        Pdf $pdf,
        MandataireRepository $mandataireRepository
    ) {
        $this->snappyPdf = $pdf;
        $this->security = $security;
        $this->mandataireRepository = $mandataireRepository;
    }

    private function isNoteOwnBy(NoteDeFraisEntity $noteDeFrais)
    {
        return $noteDeFrais &&
            $this->getMandataire() ==
                $noteDeFrais->getFicheFrais()->getMandataire();
    }

    private function getMandataire()
    {
        /** @var $user UserInterface */
        $user = $this->security->getUser();
        return $this->mandataireRepository->findOneBy([
            'user' => $user->getId(),
        ]);
    }

    /**
     * @Route("user/rapports", name="user_rapports")
     */
    public function index(
        MajeurRepository $majeurRepository,
        CompteGestionRepository $compteGestionRepository,
        ParametreMissionRepository $parametreMissionRepository,
        JugementRepository $jugementRepository
    ) {
        // TODO les jugements, parametre mission, ... ne doivent pas être nulls
        $majeur = $majeurRepository->find(6);

        $jugement = $jugementRepository->findOneBy([
            'majeur' => $majeur->getId(),
        ]);
        $pm = $parametreMissionRepository->findOneBy([
            'majeur' => $majeur->getId(),
        ]);

        // A partir du 01/01/2020, on présente les comptes de 2019 ?
        $anneeCourante = date('Y');
        $anneeCourante--;
        $anneePrecedente = $anneeCourante - 1;

        $debut = new DateTime();
        $fin = new DateTime();
        $debut->setDate($anneeCourante, 1, 1);
        $fin->setDate($anneeCourante, 12, 31);

        $comptesCourants = $compteGestionRepository->getSoldes(
            $majeur,
            $anneeCourante
        );
        $comptesPrecedents = $compteGestionRepository->getSoldes(
            $majeur,
            $anneePrecedente
        );

        $totalPrecedent = 0;
        foreach ($comptesPrecedents as $compte) {
            $totalPrecedent += $compte['solde'];
        }
        $totalCourant = 0;
        foreach ($comptesCourants as $compte) {
            $totalCourant += $compte['solde'];
        }

        $depenses = $compteGestionRepository->getDepensesParTypeOperation(
            $majeur,
            $anneeCourante
        );
        $recettes = $compteGestionRepository->getRecettesParTypeOperation(
            $majeur,
            $anneeCourante
        );

        $totalRecettes = 0;
        foreach ($recettes as $recette) {
            $totalRecettes += $recette['montant'];
        }
        $totalDepenses = 0;
        foreach ($depenses as $depense) {
            $totalDepenses += $depense['montant'];
        }

        return $this->render('rapport/cr_gestion.html.twig', [
            'majeur' => $majeur,
            'jugement' => $jugement,
            'parametreMission' => $pm,
            'annee' => $anneeCourante,
            'debut' => $debut,
            'fin' => $fin,
            'comptesCourants' => $comptesCourants,
            'comptesPrecedents' => $comptesPrecedents,
            'totalPrecedent' => $totalPrecedent,
            'totalCourant' => $totalCourant,
            'totalRecettes' => $totalRecettes,
            'totalDepenses' => $totalDepenses,
            'recettes' => $recettes,
            'depenses' => $depenses,
            'page_title' => 'Compte rendu',
        ]);
    }

    /**
     * @Route("user/rapport/{id}", name="user_rapport")
     */
    public function pdfRapport(
        MajeurEntity $majeur,
        CompteGestionRepository $compteGestionRepository,
        ParametreMissionRepository $parametreMissionRepository,
        JugementRepository $jugementRepository
    ) {
        // A partir du 01/01/2020, on présente les comptes de 2019
        $anneeCourante = date('Y');
        $anneeCourante--;
        $anneePrecedente = $anneeCourante - 1;

        $debut = new DateTime();
        $fin = new DateTime();
        $debut->setDate($anneeCourante, 1, 1);
        $fin->setDate($anneeCourante, 12, 31);

        $jugement = $jugementRepository->findOneBy([
            'majeur' => $majeur->getId(),
        ]);
        $pm = $parametreMissionRepository->findOneBy([
            'majeur' => $majeur->getId(),
        ]);

        $comptesCourants = $compteGestionRepository->getSoldes(
            $majeur,
            $anneeCourante
        );
        $comptesPrecedents = $compteGestionRepository->getSoldes(
            $majeur,
            $anneePrecedente
        );

        $totalPrecedent = 0;
        foreach ($comptesPrecedents as $compte) {
            $totalPrecedent += $compte['solde'];
        }
        $totalCourant = 0;
        foreach ($comptesCourants as $compte) {
            $totalCourant += $compte['solde'];
        }

        $depenses = $compteGestionRepository->getDepensesParTypeOperation(
            $majeur,
            $anneeCourante
        );
        $recettes = $compteGestionRepository->getRecettesParTypeOperation(
            $majeur,
            $anneeCourante
        );

        $totalRecettes = 0;
        foreach ($recettes as $recette) {
            $totalRecettes += $recette['montant'];
        }
        $totalDepenses = 0;
        foreach ($depenses as $depense) {
            $totalDepenses += $depense['montant'];
        }

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('rapport/cr_gestion.html.twig', [
            'majeur' => $majeur,
            'annee' => $anneeCourante,
            'debut' => $debut,
            'fin' => $fin,
            'comptesCourants' => $comptesCourants,
            'comptesPrecedents' => $comptesPrecedents,
            'totalPrecedent' => $totalPrecedent,
            'totalCourant' => $totalCourant,
            'totalRecettes' => $totalRecettes,
            'totalDepenses' => $totalDepenses,
            'recettes' => $recettes,
            'depenses' => $depenses,
            'page_title' => 'Compte rendu',
            'parametreMission' => $pm,
            'jugement' => $jugement,
        ]);

        return new PdfResponse(
            $this->snappyPdf->getOutputFromHtml($html),
            'rapport_' .
                // $majeur->getNom() .
                // '_' .
                // $majeur->getPrenom() .
                // '-' .
                $anneeCourante .
                '.pdf'
        );
    }
}
