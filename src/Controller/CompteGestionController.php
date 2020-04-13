<?php

namespace App\Controller;

use App\Entity\CompteGestionEntity;
use App\Form\CompteGestionFilterType;
use App\Form\CompteGestionType;
use App\Models\CompteGestionFilter;
use App\Repository\CompteGestionRepository;
use App\Repository\NatureOperationRepository;
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
     * @Route("user/comptegestions", name="user_comptesgestion")
     */
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        CompteGestionRepository $compteGestionRepository,
        NatureOperationRepository $natureOperationRepository,
        TypeOperationRepository $typeOperationRepository
    ) {
        $user = $this->security->getUser();
        $filter = $this->session->get(self::FILTER_COMPTE_GESTION, new CompteGestionFilter());

        $tos = $typeOperationRepository->findBy([], ['libelle' => 'ASC']);
        $nos = $natureOperationRepository->findBy([], ['libelle' => 'ASC']);

        $form = $this->createForm(
            CompteGestionFilterType::class,
            $filter,
            [
                'naturesOperation' => $nos,
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
            $compteGestionRepository->getFromFilter($user, $filter),
            $startPage,
            12,
            [
                'defaultSortFieldName' => 'cg.date',
                'defaultSortDirection' => 'desc'
            ]
        );

        return $this->render('compte_gestion/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
            'page_title' => 'Comptes gestion - Liste des opérations',
        ]);
    }

    /**
     * @Route("user/comptegestion/add", name="user_comptegestion_add")
     */
    public function add(Request $request)
    {
        $compteGestion = new CompteGestionEntity();

        $form = $this->createForm(CompteGestionType::class, $compteGestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($compteGestion);
            $em->flush();

            return $this->redirectToRoute('user_comptesgestion');
        }

        return $this->render(
            'compte_gestion/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle opération',
                'baseEntity' => $compteGestion,
                'url_back'    => 'user_comptesgestion',
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

            return $this->redirectToRoute('user_comptesgestion', ['id' => $compteGestion->getMajeur()->getId()]);
        }

        return $this->render(
            'compte_gestion/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une opération',
                'baseEntity' => $compteGestion,
                'url_back'    => 'user_comptesgestion',
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
