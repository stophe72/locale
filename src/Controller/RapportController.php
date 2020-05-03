<?php

namespace App\Controller;

use App\Repository\CompteGestionRepository;
use App\Repository\MajeurRepository;
use DateTime;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RapportController extends AbstractController
{
    private $snappyPdf;

    public function __construct(Pdf $pdf)
    {
        $this->snappyPdf = $pdf;
    }

    /**
     * @Route("user/rapports", name="user_rapports")
     */
    public function index(MajeurRepository $majeurRepository, CompteGestionRepository $compteGestionRepository)
    {
        $majeur = $majeurRepository->find(1);

        // A partir du 01/01/2020, on présente les comptes de 2019 ?
        $anneeCourante = date("Y");
        $anneeCourante--;
        $anneePrecedente = $anneeCourante - 1;

        $debut = new DateTime();
        $fin = new DateTime();
        $debut->setDate($anneeCourante, 1, 1);
        $fin->setDate($anneeCourante, 12, 31);

        $comptesCourants = $compteGestionRepository->getSoldes($majeur, $anneeCourante);
        $comptesPrecedents = $compteGestionRepository->getSoldes($majeur, $anneePrecedente);

        $totalPrecedent = 0;
        foreach ($comptesPrecedents as $compte) {
            $totalPrecedent += $compte['solde'];
        }
        $totalCourant = 0;
        foreach ($comptesCourants as $compte) {
            $totalCourant += $compte['solde'];
        }

        $depenses = $compteGestionRepository->getDepensesParTypeOperation($majeur, $anneeCourante);
        $recettes = $compteGestionRepository->getRecettesParTypeOperation($majeur, $anneeCourante);

        $totalRecettes = 0;
        foreach ($recettes as $recette) {
            $totalRecettes += $recette['montant'];
        }
        $totalDepenses = 0;
        foreach ($depenses as $depense) {
            $totalDepenses += $depense['montant'];
        }

        return $this->render(
            'rapport/cr_gestion.html.twig',
            [
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
            ]
        );
    }

    /**
     * @Route("user/rapports2", name="user_rapports2")
     */
    public function pdfRapport(MajeurRepository $majeurRepository, CompteGestionRepository $compteGestionRepository)
    {
        $majeur = $majeurRepository->find(1);

        // A partir du 01/01/2020, on présente les comptes de 2019
        $anneeCourante = date("Y");
        $anneeCourante--;
        $anneePrecedente = $anneeCourante - 1;

        $debut = new DateTime();
        $fin = new DateTime();
        $debut->setDate($anneeCourante, 1, 1);
        $fin->setDate($anneeCourante, 12, 31);

        $comptesCourants = $compteGestionRepository->getSoldes($majeur, $anneeCourante);
        $comptesPrecedents = $compteGestionRepository->getSoldes($majeur, $anneePrecedente);

        $totalPrecedent = 0;
        foreach ($comptesPrecedents as $compte) {
            $totalPrecedent += $compte['solde'];
        }
        $totalCourant = 0;
        foreach ($comptesCourants as $compte) {
            $totalCourant += $compte['solde'];
        }

        $depenses = $compteGestionRepository->getDepensesParTypeOperation($majeur, $anneeCourante);
        $recettes = $compteGestionRepository->getRecettesParTypeOperation($majeur, $anneeCourante);

        $totalRecettes = 0;
        foreach ($recettes as $recette) {
            $totalRecettes += $recette['montant'];
        }
        $totalDepenses = 0;
        foreach ($depenses as $depense) {
            $totalDepenses += $depense['montant'];
        }

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView(
            'rapport/cr_gestion.html.twig',
            [
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
            ]
        );

        return new PdfResponse(
            $this->snappyPdf->getOutputFromHtml($html),
            'rapport_' . $majeur->getNom() . '_' . $majeur->getPrenom() . '-' . $anneeCourante . '.pdf'
        );
    }
}
