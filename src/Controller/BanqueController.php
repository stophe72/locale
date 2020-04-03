<?php

namespace App\Controller;

use App\Entity\BanqueEntity;
use App\Form\BanqueType;
use App\Repository\BanqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class BanqueController extends AbstractController
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
     * @Route("user/banques", name="user_banques")
     */
    public function index(BanqueRepository $banqueRepository)
    {
        return $this->render('banque/index.html.twig', [
            'banques' => $banqueRepository->findBy([], ['libelle' => 'ASC']),
            'page_title' => 'Liste des banques',
        ]);
    }

    /**
     * @Route("user/banque/add", name="user_banque_add")
     */
    public function add(Request $request)
    {
        $banque = new BanqueEntity();

        $form = $this->createForm(BanqueType::class, $banque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($banque);
            $em->flush();

            return $this->redirectToRoute('user_banques');
        }

        return $this->render(
            'banque/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouvelle banque',
                'baseEntity' => $banque,
                'url_back'    => 'user_banques',
            ]
        );
    }

    /**
     * @Route("user/banque/edit/{id}", name="user_banque_edit")
     */
    public function edit(BanqueEntity $banque, Request $request)
    {
        $form = $this->createForm(BanqueType::class, $banque);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($banque->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_banques');
        }

        return $this->render(
            'banque/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier une banque',
                'baseEntity' => $banque,
                'url_back'    => 'user_banques',
            ]
        );
    }

    /**
     * @Route("user/potager/ajaxCanDeleteBanque", name="ajaxCanDeleteBanque")
     */
    /*public function ajaxCanDeleteBanque(
        Request $request,
        IParcelleRepository $parcelleRepository
    ) {
        $user = $this->security->getUser();

        $potagerId = $request->get(self::REQUEST_KEY_POTAGER_ID, -1);
        $parcelles = $parcelleRepository->findBy(['potager' => $potagerId, 'user' => $user->getId()]);

        return new JsonResponse(['data' => empty($parcelles)]);
    }*/
}
