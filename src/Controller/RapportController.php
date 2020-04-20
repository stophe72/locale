<?php

namespace App\Controller;

use App\Repository\CompteGestionRepository;
use App\Repository\MajeurRepository;
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

        // $familles = $compteGestionRepository->findBy('')

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $dompdf->set_base_path("/public/css/");

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView(
            'rapport/cr_gestion.html.twig',
            [
                'majeur' => $majeur,
                'annee' => date('Y'),
                'debut' => date('m/d/Y'),
                'fin' => date('m/d/Y'),
                'page_title' => 'Compte rendu',
            ]
        );
        /*
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
        return $this->render(
            'rapport/cr_gestion.html.twig',
            [
                'majeur' => $majeur,
                'annee' => date('Y'),
                'debut' => date('m/d/Y'),
                'fin' => date('m/d/Y'),
                'page_title' => 'Compte rendu',
            ]
        );

        // return $this->render('rapport/index.html.twig', [
        //     'controller_name' => 'RapportController',
        // ]);
    }
}
