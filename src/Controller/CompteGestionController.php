<?php

namespace App\Controller;

use App\Entity\CompteGestionEntity;
use App\Entity\DonneeBancaireEntity;
use App\Form\CompteGestionFilterType;
use App\Form\CompteGestionType;
use App\Models\CompteGestionFilter;
use App\Repository\CompteGestionRepository;
use App\Repository\TypeOperationRepository;
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
     * @var Security
     */
    private $security;

    /**
     * Variable membre pour la session
     *
     * @var SessionInterface
     */
    private $session;

    /**
     * Constructeur
     *
     * @param $session SessionInterface
     */
    public function __construct(Security $security, SessionInterface $sessionInterface)
    {
        $this->security = $security;
        $this->session = $sessionInterface;
    }

    /**
     * @Route("user/comptegestions/{id}", name="user_comptesgestion")
     */
    public function index(
        DonneeBancaireEntity $donneeBancaire,
        Request $request,
        PaginatorInterface $paginator,
        CompteGestionRepository $compteGestionRepository,
        TypeOperationRepository $typeOperationRepository
    ) {
        $user = $this->security->getUser();
        $filter = $this->session->get(self::FILTER_COMPTE_GESTION, new CompteGestionFilter());

        $tos = $typeOperationRepository->findBy([], ['libelle' => 'ASC']);

        $cgs = $compteGestionRepository->findBy(
            [
                'user' => $user->getId(),
                'donneeBancaire' => $donneeBancaire->getId(),
            ],
            [
                'date' => 'DESC',
            ]
        );

        $form = $this->createForm(
            CompteGestionFilterType::class,
            $filter,
            [
                'typesOperation' => $tos,
            ]
        );
        $form->handleRequest($request);

        $startPage = $request->get('page', 1);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->session->set(self::FILTER_COMPTE_GESTION, $filter);
            $startPage = 1;
        }

        $pagination = $paginator->paginate(
            // $cgs,
            $compteGestionRepository->getFromFilter($user, $donneeBancaire, $filter),
            $startPage,
            10,
            [
                'defaultSortFieldName' => 'cg.date',
                'defaultSortDirection' => 'desc'
            ]
        );

        return $this->render('compte_gestion/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
            'page_title' => 'Comptes gestion - ' . $donneeBancaire->getMajeur()->__toString() . ' - ' . $donneeBancaire->getNumeroCompte(),
            'donneeBancaire' => $donneeBancaire,
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

            return $this->redirectToRoute('user_comptesgestion', ['id' => $compteGestion->getDonneeBancaire()->getId()]);
        }

        return $this->render(
            'compte_gestion/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle opération',
                'baseEntity' => $compteGestion,
                'url_back'    => $this->generateUrl(
                    'user_comptesgestion',
                    [
                        'id' => $compteGestion->getDonneeBancaire()->getId(),
                    ]
                ),
            ]
        );
    }

    /**
     * @Route("user/comptegestion/edit/{id}", name="user_comptegestion_edit")
     */
    public function edit(CompteGestionEntity $compteGestion, Request $request)
    {
        $form = $this->createForm(CompteGestionType::class, $compteGestion);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($compteGestion->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_comptesgestion', ['id' => $compteGestion->getDonneeBancaire()->getId()]);
        }

        return $this->render(
            'compte_gestion/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une opération',
                'baseEntity' => $compteGestion,
                'url_back'    => $this->generateUrl(
                    'user_comptesgestion',
                    [
                        'id' => $compteGestion->getDonneeBancaire()->getId(),
                    ]
                ),
            ]
        );
    }

    /**
     * @Route("user/comptegestion/ajaxCompteGestionClearFilter", name="ajaxCompteGestionClearFilter")
     */
    public function ajaxCultureClearFilter(Request $request)
    {
        if ($request->get('clearCompteGestionFilter', 0)) {
            $this->session->remove(self::FILTER_COMPTE_GESTION);
        }
        return new JsonResponse(
            [
                'success' => 1,
            ]
        );
    }
}
