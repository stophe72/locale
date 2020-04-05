<?php

namespace App\Controller;

use App\Entity\PeriodeEntity;
use App\Form\PeriodeType;
use App\Repository\PeriodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PeriodeController extends AbstractController
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
     * @Route("user/periodes", name="user_periodes")
     */
    public function index(PeriodeRepository $periodeRepository)
    {
        return $this->render('periode/index.html.twig', [
            'periodes' => $periodeRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des périodes',
        ]);
    }

    /**
     * @Route("user/periode/add", name="user_periode_add")
     */
    public function add(Request $request)
    {
        $periode = new PeriodeEntity();

        $form = $this->createForm(PeriodeType::class, $periode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($periode);
            $em->flush();

            return $this->redirectToRoute('user_periodes');
        }

        return $this->render(
            'periode/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle période',
                'baseEntity' => $periode,
                'url_back'    => 'user_periodes',
            ]
        );
    }

    /**
     * @Route("user/periode/edit/{id}", name="user_periode_edit")
     */
    public function edit(PeriodeEntity $periode, Request $request)
    {
        $form = $this->createForm(PeriodeType::class, $periode);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($periode->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_periodes');
        }

        return $this->render(
            'periode/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une période',
                'baseEntity' => $periode,
                'url_back'    => 'user_periodes',
            ]
        );
    }
}
