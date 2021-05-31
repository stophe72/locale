<?php

namespace App\Controller;

use App\Entity\CompteGestionEntity;
use App\Entity\DonneeBancaireEntity;
use App\Form\CompteGestionFilterType;
use App\Form\CompteGestionImportType;
use App\Form\CompteGestionType;
use App\Form\ImportCompteGestionType;
use App\Models\CompteGestionFilter;
use App\Models\CompteGestionImport;
use App\Models\ImportCompteGestion;
use App\Repository\CompteGestionRepository;
use App\Repository\FamilleTypeOperationRepository;
use App\Repository\ImportOperationRepository;
use App\Repository\MandataireRepository;
use App\Repository\TypeOperationRepository;
use App\Util\ImportManager;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CompteGestionController extends AbstractController
{
    const FILTER_COMPTE_GESTION = 'session_filter_compte_gestion';

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
        $user = $this->security->getUser();
        return $this->mandataireRepository->findOneBy([
            'user' => $user->getId(),
        ]);
    }

    private function isInSameGroupe(CompteGestionEntity $compteGestion)
    {
        return $compteGestion &&
            $this->getMandataire()->getGroupe() ==
                $compteGestion
                    ->getDonneeBancaire()
                    ->getMajeur()
                    ->getGroupe();
    }

    /**
     * @Route("user/comptegestions/{id}", name="user_comptesgestion")
     */
    public function index(
        DonneeBancaireEntity $donneeBancaire,
        Request $request,
        PaginatorInterface $paginator,
        TypeOperationRepository $typeOperationRepository,
        FamilleTypeOperationRepository $familleTypeOperationRepository,
        ImportOperationRepository $importOperationRepository,
        CompteGestionRepository $compteGestionRepository
    ) {
        $filter = $this->session->get(
            self::FILTER_COMPTE_GESTION,
            new CompteGestionFilter()
        );

        $tos = $typeOperationRepository->findBy([], ['libelle' => 'ASC']);
        $ftos = $familleTypeOperationRepository->findBy(
            [],
            ['libelle' => 'ASC']
        );

        $form = $this->createForm(CompteGestionFilterType::class, $filter, [
            'typeOperations' => $tos,
            'familleTypeOperations' => $ftos,
        ]);
        $form->handleRequest($request);

        $import = new ImportCompteGestion();
        $formImport = $this->createForm(
            ImportCompteGestionType::class,
            $import
        );
        $formImport->handleRequest($request);

        if ($formImport->isSubmitted() && $formImport->isValid()) {
            $fichier = $formImport['nomFichier']->getData();
            if ($fichier) {
                $file = file($fichier->getPathname());

                $im = new ImportManager();
                $comptesGestion = $im->parseCsv(
                    $donneeBancaire,
                    $file,
                    $importOperationRepository
                );
                if (count($comptesGestion) > 0) {
                    return $this->redirectToRoute('user_comptegestion_import', [
                        'compteGestions' => $comptesGestion,
                    ]);
                }
            }
        }

        $startPage = $request->get('page', 1);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->session->set(self::FILTER_COMPTE_GESTION, $filter);
            $startPage = 1;
        }

        $pagination = $paginator->paginate(
            $compteGestionRepository->getFromFilter(
                $this->getMandataire(),
                $donneeBancaire,
                $filter
            ),
            $startPage,
            8,
            [
                'defaultSortFieldName' => 'cg.date',
                'defaultSortDirection' => 'desc',
            ]
        );

        return $this->render('compte_gestion/index.html.twig', [
            'form' => $form->createView(),
            'formImport' => $formImport->createView(),
            'pagination' => $pagination,
            'page_title' =>
                'Comptes gestion - ' .
                $donneeBancaire->getMajeur()->__toString() .
                ' - ' .
                $donneeBancaire->getNumeroCompte(),
            'donneeBancaire' => $donneeBancaire,
        ]);
    }

    /**
     * @Route("user/comptegestion/import/{donneeBancaire}", name="user_comptegestion_import")
     */
    public function import(
        DonneeBancaireEntity $donneeBancaire,
        ImportOperationRepository $importOperationRepository,
        Request $request
        ) {
        $compteGestions = new ArrayCollection();

        $import = new ImportCompteGestion();
        $formFile = $this->createForm(ImportCompteGestionType::class, $import);
        $formFile->handleRequest($request);

        if ($formFile->isSubmitted() && $formFile->isValid()) {
            $fichier = $formFile['nomFichier']->getData();
            if ($fichier) {
                $file = file($fichier->getPathname());

                $im = new ImportManager();
                $compteGestions = $im->parseCsv(
                    $donneeBancaire,
                    $file,
                    $importOperationRepository
                );
                $compteGestions = new ArrayCollection($compteGestions);
            }
        }

        $compteGestionImport = new CompteGestionImport();
        $compteGestionImport->setCompteGestions($compteGestions);

        $formImport = $this->createForm(
            CompteGestionImportType::class,
            $compteGestionImport
        );
        $formImport->handleRequest($request);

        if ($formImport->isSubmitted() && $formImport->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($compteGestions as $cg) {
                $em->persist($cg);
            }
            $em->flush();
        }
        return $this->render('compte_gestion/import.html.twig', [
            'page_title' => 'Import',
            'donneeBancaire' => $donneeBancaire,
            'formFile' => $formFile->createView(),
            'formImport' => $formImport->createView(),
            'url_back' => $this->generateUrl('user_comptesgestion', [
                'id' => $donneeBancaire->getId(),
            ]),
        ]);
    }

    /**
     * @Route("user/comptegestion/add/{donneeBancaire}", name="user_comptegestion_add")
     */
    public function add(DonneeBancaireEntity $donneeBancaire, Request $request)
    {
        $compteGestion = new CompteGestionEntity();
        $compteGestion->setDonneeBancaire($donneeBancaire);

        $form = $this->createForm(CompteGestionType::class, $compteGestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($compteGestion);
            $em->flush();

            return $this->redirectToRoute('user_comptesgestion', [
                'id' => $compteGestion->getDonneeBancaire()->getId(),
            ]);
        }

        return $this->render('compte_gestion/new_or_edit.html.twig', [
            'form' => $form->createView(),
            'page_title' => 'Nouvelle opération',
            'baseEntity' => $compteGestion,
            'url_back' => $this->generateUrl('user_comptesgestion', [
                'id' => $compteGestion->getDonneeBancaire()->getId(),
            ]),
        ]);
    }

    /**
     * @Route("user/comptegestion/edit/{compteGestion}", name="user_comptegestion_edit")
     */
    public function edit(CompteGestionEntity $compteGestion, Request $request)
    {
        $form = $this->createForm(CompteGestionType::class, $compteGestion);
        $form->handleRequest($request);

        if (
            $this->isInSameGroupe($compteGestion) &&
            $form->isSubmitted() &&
            $form->isValid()
        ) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('user_comptesgestion', [
                'id' => $compteGestion->getDonneeBancaire()->getId(),
            ]);
        }

        return $this->render('compte_gestion/new_or_edit.html.twig', [
            'form' => $form->createView(),
            'page_title' => 'Modifier une opération',
            'baseEntity' => $compteGestion,
            'url_back' => $this->generateUrl('user_comptesgestion', [
                'id' => $compteGestion->getDonneeBancaire()->getId(),
            ]),
        ]);
    }

    /**
     * @Route("user/comptegestion/ajaxCompteGestionClearFilter", name="ajaxCompteGestionClearFilter")
     */
    public function ajaxCompteGestionClearFilter(Request $request)
    {
        if ($request->get('clearCompteGestionFilter', 0)) {
            $this->session->remove(self::FILTER_COMPTE_GESTION);
        }
        return new JsonResponse([
            'success' => 1,
        ]);
    }

    /**
     * @Route("user/comptegestion/delete/{id}", name="user_comptegestion_delete")
     */
    public function delete(CompteGestionEntity $compteGestion)
    {
        if ($this->isInSameGroupe($compteGestion)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($compteGestion);
            $em->flush();
        }
        return $this->redirectToRoute('user_comptesgestion', [
            'id' => $compteGestion->getDonneeBancaire()->getId(),
        ]);
    }
}
