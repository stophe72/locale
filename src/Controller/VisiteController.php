<?php

namespace App\Controller;

use App\Entity\VisiteEntity;
use App\Form\VisiteFilterType;
use App\Form\VisiteType;
use App\Models\VisiteFilter;
use App\Repository\MajeurRepository;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class VisiteController extends AbstractController
{
    const FILTER_VISITE = 'session_filter_visite';

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
     * @Route("user/visites", name="user_visites")
     */
    public function index(Request $request, PaginatorInterface $paginator, VisiteRepository $visiteRepository)
    {
        $user = $this->security->getUser();
        $filter = $this->session->get(self::FILTER_VISITE, new VisiteFilter());

        $form = $this->createForm(VisiteFilterType::class, $filter);
        $form->handleRequest($request);

        $startPage = $request->get('page', 1);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->session->set(self::FILTER_VISITE, $filter);
            $startPage = 1;
        }

        $pagination = $paginator->paginate(
            $visiteRepository->getFromFilter($user, $filter),
            $startPage,
            12,
            [
                'defaultSortFieldName' => 'v.date',
                'defaultSortDirection' => 'desc'
            ]
        );

        return $this->render('visite/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
            'page_title' => 'Liste des visites',
        ]);
    }

    /**
     * @Route("user/visite/add", name="user_visite_add")
     */
    public function add(Request $request, MajeurRepository $majeurRepository)
    {
        $visite = new VisiteEntity();
        $user = $this->security->getUser();
        $majeurs =  $majeurRepository->getAllOrderByNomPrenom($user);

        $form = $this->createForm(VisiteType::class, $visite, ['majeurs' => $majeurs]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visite->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($visite);
            $em->flush();

            return $this->redirectToRoute('user_visites');
        }

        return $this->render(
            'visite/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouvelle visite',
                'baseEntity' => $visite,
                'url_back' => 'user_visites',
            ]
        );
    }

    /**
     * @Route("user/visite/edit/{id}", name="user_visite_edit")
     */
    public function edit(VisiteEntity $visite, Request $request, MajeurRepository $majeurRepository)
    {
        $user = $this->security->getUser();
        $majeurs =  $majeurRepository->getAllOrderByNomPrenom($user);

        $form = $this->createForm(VisiteType::class, $visite, ['majeurs' => $majeurs]);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($visite->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_visites');
        }

        return $this->render(
            'visite/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Modifier une visite',
                'baseEntity' => $visite,
                'url_back' => 'user_visites',
            ]
        );
    }
    /**
     * @Route("user/culture/ajaxVisiteClearFilter", name="ajax_visite_clear_filter")
     */
    public function ajaxVisiteClearFilter(Request $request)
    {
        if ($request->get('clearVisiteFilter', 0)) {
            $this->session->remove(self::FILTER_VISITE);
        }
        return new JsonResponse(
            [
                'success' => 1,
            ]
        );
    }
}
