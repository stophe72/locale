<?php

namespace App\Controller;

use App\Entity\MajeurEntity;
use App\Form\MajeurType;
use App\Repository\DonneeBancaireRepository;
use App\Repository\MajeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MajeurController extends AbstractController
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
     * @Route("user/majeurs", name="user_majeurs")
     */
    public function index(MajeurRepository $majeurRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $majeurs = $majeurRepository->findBy([], ['nom' => 'ASC']);


        return $this->render('majeur/index.html.twig', [
            'majeurs' => $majeurs,
            'page_title' => 'Liste des majeurs',
        ]);
    }

    /**
     * @Route("user/majeur/add", name="user_majeur_add")
     */
    public function add(Request $request)
    {
        $majeur = new MajeurEntity();

        $form = $this->createForm(MajeurType::class, $majeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($majeur);
            $em->flush();

            return $this->redirectToRoute('user_majeurs');
        }

        return $this->render(
            'majeur/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouveau majeur',
                'baseEntity' => $majeur,
                'url_back'    => $this->generateUrl('user_majeurs'),
            ]
        );
    }

    /**
     * @Route("user/majeur/edit/{id}", name="user_majeur_edit")
     */
    public function edit(Request $request, MajeurEntity $majeur, MajeurRepository $majeurRepository)
    {
        $form = $this->createForm(MajeurType::class, $majeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($majeur);
            $em->flush();

            return $this->redirectToRoute('user_majeurs');
        }

        return $this->render(
            'majeur/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Editer un majeur',
                'baseEntity' => $majeur,
                'url_back'    => $this->generateUrl('user_majeurs'),
            ]
        );
    }

    /**
     * @Route("user/majeur/ajaxMajeursGetByName", name="ajax_majeurs_get_by_name")
     */
    public function ajaxMajeursGetByName(Request $request, MajeurRepository $majeurRepository)
    {
        $name = $request->get('name');
        $user = $this->security->getUser();

        /** @var MajeurEntity[] $majeurs */
        $majeurs = $majeurRepository->findByName($name, $user);
        $a       = [];
        foreach ($majeurs as $majeur) {
            $a[] = [
                'value' => $majeur->getId(),
                'label' => $majeur->getNom(),
            ];
        }
        return new JsonResponse($a);
    }

    /**
     * @Route("user/majeur/show/{id}", name="user_majeur_show")
     */
    public function show(MajeurEntity $majeur, DonneeBancaireRepository $donneeBancaireRepository)
    {
        $user = $this->security->getUser();
        if ($majeur && $majeur->isOwnBy($user)) {
            $dbs = $donneeBancaireRepository->findBy(['user' => $user, 'majeur' => $majeur,], []);
            return $this->render(
                'majeur/show.html.twig',
                [
                    'donneeBancaires' => $dbs,
                    'majeur' => $majeur,
                    'page_title' => 'Détails d\'un majeur',
                    'url_back'   => $this->generateUrl('user_majeurs'),
                ]
            );
        }
        return $this->redirectToRoute('user_majeurs');
    }
}
