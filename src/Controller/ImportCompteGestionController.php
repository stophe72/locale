<?php

namespace App\Controller;

use App\Form\ImportCompteGestionType;
use App\Models\ImportCompteGestion;
use App\Repository\ImportOperationRepository;
use App\Repository\MajeurRepository;
use App\Util\ImportManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ImportCompteGestionController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * Constructeur
     *
     * @param $session SessionInterface
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("user/importcomptegestion", name="user_importcomptegestion")
     */
    public function index(Request $request, MajeurRepository $majeurRepository, ImportOperationRepository $importOperationRepository)
    {
        $import = new ImportCompteGestion();
        $user = $this->security->getUser();
        $majeurs = $majeurRepository->findBy(['user' => $user->getId()], ['nom' => 'ASC',]);
        $form = $this->createForm(
            ImportCompteGestionType::class,
            $import,
            [
                'majeurs' => $majeurs,
            ]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fichier = $form['nomFichier']->getData();
            if ($fichier) {
                $file = file($fichier->getPathname());

                $im = new ImportManager();
                $comptesGestion = $im->parseCsv($import->getDonneeBancaire(), $file, $importOperationRepository);

                $em = $this->getDoctrine()->getManager();
                foreach ($comptesGestion['ok'] as $cg) {
                    $em->persist($cg);
                }
                $em->flush();

                return $this->render(
                    'import_compte_gestion/resultat_import.html.twig',
                    [
                        'page_title' => 'Résultat import',
                        'comptesGestion' => $comptesGestion,
                        'donneeBancaire' => $import->getDonneeBancaire(),
                        'url_back' => $this->generateUrl(
                            'user_comptesgestion',
                            [
                                'id' => $import->getDonneeBancaire(),
                            ]
                        )
                    ]
                );
            }
        }

        return $this->render('import_compte_gestion/index.html.twig', [
            'page_title' => 'Import CSV Compte Gestion',
            'form' => $form->createView(),
        ]);
    }
}
