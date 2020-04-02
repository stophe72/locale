<?php

namespace App\Controller;

use App\Entity\TribunalEntity;
use App\Form\TribunalType;
use App\Repository\TribunalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TribunalController extends AbstractController
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
     * @Route("user/tribunaux", name="user_tribunaux")
     */
    public function index(TribunalRepository $tribunalRepository)
    {
        return $this->render('tribunal/index.html.twig', [
            'tribunaux' => $tribunalRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des tribunaux',
        ]);
    }

    /**
     * @Route("user/tribunal/add", name="user_tribunal_add")
     */
    public function add(Request $request, TribunalRepository $tribunalRepository)
    {
        $tribunal = new TribunalEntity();

        $form = $this->createForm(TribunalType::class, $tribunal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tribunal);
            $em->flush();

            return $this->redirectToRoute('user_tribunaux');
        }

        return $this->render(
            'tribunal/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouveau tribunal',
                'baseEntity' => $tribunal,
                'url_back'    => 'user_tribunaux',
            ]
        );
    }

    /**
     * @Route("user/tribunal/edit/{id}", name="user_tribunal_edit")
     */
    public function edit(TribunalEntity $tribunal, Request $request)
    {
        $form = $this->createForm(TribunalType::class, $tribunal);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($tribunal->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_tribunaux');
        }

        return $this->render(
            'tribunal/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un tribunal',
                'baseEntity' => $tribunal,
                'url_back'    => 'user_tribunaux',
            ]
        );
    }
}
