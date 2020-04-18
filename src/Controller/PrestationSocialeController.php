<?php

namespace App\Controller;

use App\Entity\PrestationSocialeEntity;
use App\Form\PrestationSocialeType;
use App\Repository\PrestationSocialeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PrestationSocialeController extends AbstractController
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
     * @Route("user/prestationsociales", name="user_prestationsociales")
     */
    public function index(PrestationSocialeRepository $prestationSocialeRepository)
    {
        return $this->render('prestation_sociale/index.html.twig', [
            'prestation_sociales' => $prestationSocialeRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des prestations sociales',
        ]);
    }

    /**
     * @Route("user/prestationsociale/add", name="user_prestationsociale_add")
     */
    public function add(Request $request)
    {
        $prestationSociale = new PrestationSocialeEntity();

        $form = $this->createForm(PrestationSocialeType::class, $prestationSociale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prestationSociale);
            $em->flush();

            return $this->redirectToRoute('user_prestationsociales');
        }

        return $this->render(
            'prestation_sociale/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle prestation sociale',
                'baseEntity' => $prestationSociale,
                'url_back'    => $this->generateUrl('user_prestationsociales'),
            ]
        );
    }

    /**
     * @Route("user/prestationsociale/edit/{id}", name="user_prestationsociale_edit")
     */
    public function edit(PrestationSocialeEntity $prestationSociale, Request $request)
    {
        $form = $this->createForm(PrestationSocialeType::class, $prestationSociale);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($prestationSociale->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_prestationsociales');
        }

        return $this->render(
            'prestation_sociale/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une prestation_sociale',
                'baseEntity' => $prestationSociale,
                'url_back'    => $this->generateUrl('user_prestationsociales'),
            ]
        );
    }
}
