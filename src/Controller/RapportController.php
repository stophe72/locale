<?php

namespace App\Controller;

use App\Repository\CompteGestionRepository;
use App\Repository\MajeurRepository;
use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RapportController extends AbstractController
{
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

        /*
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $dompdf->set_base_path("/public/css/");

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView(
            'rapport/cr_gestion.html.twig',
            [
                'majeur' => $majeur,
                'annee' => $anneeCourante,
                'debut' => date('m/d/Y'),
                'fin' => date('m/d/Y'),
                'totalPrecedent' => $totalPrecedent,
                'totalCourant' => $totalCourant,
                'page_title' => 'Compte rendu',
            ]
        );

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
*/


        // return $this->render('rapport/index.html.twig', [
        //     'controller_name' => 'RapportController',
        // ]);
    }
}
