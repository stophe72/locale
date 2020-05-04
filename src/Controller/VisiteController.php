<?php

namespace App\Controller;

use App\Entity\VisiteEntity;
use App\Form\CalendrierFilterType;
use App\Form\VisiteFilterType;
use App\Form\VisiteType;
use App\Models\CalendrierVisiteFilter;
use App\Models\VisiteFilter;
use App\Repository\MajeurRepository;
use App\Repository\VisiteRepository;
use App\Util\Calendrier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class VisiteController extends AbstractController
{
    const FILTER_VISITE = 'session_filter_visite';
    const FILTER_CALENDRIER = 'session_filter_calendrier';

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
	 * @param Security         $security
	 * @param SessionInterface $sessionInterface
	 */
    public function __construct(Security $security, SessionInterface $sessionInterface)
    {
        $this->security = $security;
        $this->session = $sessionInterface;
    }

	/**
	 * @Route("user/visites", name="user_visites")
	 * @param Request            $request
	 * @param PaginatorInterface $paginator
	 * @param VisiteRepository   $visiteRepository
	 * @return Response
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
	 * @param Request          $request
	 * @param MajeurRepository $majeurRepository
	 * @return RedirectResponse|Response
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
                'url_back' => $this->generateUrl('user_visites'),
            ]
        );
    }

	/**
	 * @Route("user/visite/edit/{id}", name="user_visite_edit")
	 * @param VisiteEntity     $visite
	 * @param Request          $request
	 * @param MajeurRepository $majeurRepository
	 * @return RedirectResponse|Response
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
                'url_back' => $this->generateUrl('user_visites'),
            ]
        );
    }

	/**
	 * @Route("user/visites/calendrier", name="user_visites_calendrier")
	 * @param Request          $request
	 * @param VisiteRepository $visiteRepository
	 * @return Response
	 */
    public function calendrier(Request $request, VisiteRepository $visiteRepository)
    {
        $user = $this->security->getUser();
        $filter = $this->session->get(self::FILTER_CALENDRIER, new CalendrierVisiteFilter());

        $form = $this->createForm(CalendrierFilterType::class, $filter);
        $form->handleRequest($request);

        $visites = $visiteRepository->getFromCalendrierFilter($user, $filter);
        $calendrier = new Calendrier($visites, $filter->getAnnee());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->session->set(self::FILTER_CALENDRIER, $filter);
        }

        return $this->render(
            'visite/calendrier.html.twig',
            [
                'form' => $form->createView(),
                // 'baseEntity' => $visite,
                'page_title' => 'Calendrier des visites',
                'calendrier' => $calendrier->generate(),
                // 'url_back' => $this->generateUrl('user_visites'),
            ]
        );
    }

	/**
	 * @Route("user/visite/ajaxVisiteClearFilter", name="ajax_visite_clear_filter")
	 * @param Request $request
	 * @return JsonResponse
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

	/**
	 * @Route("user/visite/ajaxCalendrierClearFilter", name="ajax_calendrier_clear_filter")
	 * @param Request $request
	 * @return JsonResponse
	 */
    public function ajaxCalendrierClearFilter(Request $request)
    {
        if ($request->get('clearCalendrierFilter', 0)) {
            $this->session->remove(self::FILTER_CALENDRIER);
        }
        return new JsonResponse(
            [
                'success' => 1,
            ]
        );
    }
}
