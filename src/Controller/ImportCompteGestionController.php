<?php

namespace App\Controller;

use App\Entity\CompteGestionEntity;
use App\Entity\ImportOperationEntity;
use App\Entity\MajeurEntity;
use App\Form\ImportCompteGestionType;
use App\Models\ImportCompteGestion;
use App\Repository\ImportOperationRepository;
use App\Repository\MajeurRepository;
use App\Repository\TypeOperationRepository;
use App\Util\ImportManager;
use DateTime;
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

                $comptesGestion = ImportManager::parseCsv($import->getMajeur(), $file, $importOperationRepository);

                return $this->render('import_compte_gestion/resultat_import.html.twig', [
                    'page_title' => 'Résultat import',
                    'majeur' => $import->getMajeur(),
                    'comptesGestion' => $comptesGestion,
                    // 'form' => $form->createView(),
                ]);
            }
        }

        return $this->render('import_compte_gestion/index.html.twig', [
            'page_title' => 'Import CSV Compte Gestion',
            'form' => $form->createView(),
        ]);
    }

    private function parseCsv(MajeurEntity $majeur, $file)
    {
        $importOperationRepo = $this->getDoctrine()->getRepository(ImportOperationEntity::class);
        $cgs = [];
        foreach ($file as $row) {
            $data = str_getcsv($row);

            $date = DateTime::createFromFormat('d/m/Y', $data['0']);
            $tos = $importOperationRepo->findByMatchLibelle($data['1']);

            $compteGestion = new CompteGestionEntity();
            $compteGestion->setDate($date);
            $compteGestion->setMajeur($majeur);
            $compteGestion->setMontant($data[2]);

            if (count($tos) == 1) {
                $compteGestion->setTypeOperation($tos[0]->getTypeOperation());
            }

            $cgs[] = $compteGestion;
        }
        return $cgs;
    }
}
