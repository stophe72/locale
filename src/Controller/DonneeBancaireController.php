<?php

namespace App\Controller;

use App\Entity\DonneeBancaireEntity;
use App\Form\DonneeBancaireType;
use App\Repository\DonneeBancaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DonneeBancaireController extends AbstractController
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
     * @Route("user/donneebancaires", name="user_donneebancaires")
     */
    public function index(DonneeBancaireRepository $donneeBancaireRepository)
    {
        $user = $this->security->getUser();

        $dbs = $donneeBancaireRepository->findBy(['user' => $user->getId()]);

        return $this->render('donnee_bancaire/index.html.twig', [
            'donneebancaires' => $dbs,
            'page_title' => 'Liste des données bancaires',
        ]);
    }

    /**
     * @Route("user/donneebancaire/add", name="user_donneebancaire_add")
     */
    public function add(Request $request)
    {
        $db = new DonneeBancaireEntity();

        $form = $this->createForm(DonneeBancaireType::class, $db);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($db);
            $em->flush();

            return $this->redirectToRoute('user_donneebancaires');
        }

        return $this->render('donnee_bancaire/new_or_edit.html.twig', [
            'page_title' => 'Ajouter une donnée bancaire',
            'form' => $form->createView(),
            'baseEntity' => $db,
            'url_back' => 'user_donneebancaires',
        ]);
    }

    /**
     * @Route("user/donneebancaire/edit/{id}", name="user_donneebancaire_edit")
     */
    public function edit(DonneeBancaireEntity $donneeBancaire, Request $request)
    {
        $form = $this->createForm(DonneeBancaireType::class, $donneeBancaire);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($donneeBancaire->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($donneeBancaire);
            $em->flush();

            return $this->redirectToRoute('user_donneebancaires');
        }

        return $this->render('donnee_bancaire/new_or_edit.html.twig', [
            'page_title' => 'Editer une donnée bancaire',
            'form' => $form->createView(),
            'baseEntity' => $donneeBancaire,
            'url_back' => 'user_donneebancaires',
        ]);
    }
}
