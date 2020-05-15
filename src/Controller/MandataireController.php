<?php

namespace App\Controller;

use App\Entity\MandataireEntity;
use App\Form\MandataireType;
use App\Repository\MandataireRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class MandataireController extends AbstractController
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
     * @Route("admin/mandataires", name="admin_mandataires")
     */
    public function index(MandataireRepository $mandataireRepository)
    {
        $user = $this->security->getUser();

        $mandataires = $mandataireRepository->findBy(
            [
                'user' => $user->getId(),
            ]
        );

        return $this->render('mandataire/index.html.twig', [
            'mandataires' => $mandataires,
            'page_title' => 'Liste des mandataires',
        ]);
    }

    /**
     * @Route("admin/mandataire/add/", name="admin_mandataire_add")
     */
    public function add(Request $request)
    {
        $mandataire = new MandataireEntity();

        $form = $this->createForm(MandataireType::class, $mandataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mandataire);
            $em->flush();

            return $this->redirectToRoute('admin_mandataires');
        }

        return $this->render('mandataire/new_or_edit.html.twig', [
            'page_title' => 'Ajouter un mandataire',
            'form' => $form->createView(),
            'baseEntity' => $mandataire,
            'url_back' => $this->generateUrl('admin_mandataires'),
        ]);
    }

    /**
     * @Route("admin/mandataire/edit/{id}", name="admin_mandataire_edit")
     */
    public function edit(MandataireEntity $mandataire, Request $request)
    {
        $form = $this->createForm(MandataireType::class, $mandataire);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($mandataire->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mandataire);
            $em->flush();

            return $this->redirectToRoute('admin_mandataires');
        }

        return $this->render('mandataire/new_or_edit.html.twig', [
            'page_title' => 'Editer un mandataire',
            'form' => $form->createView(),
            'baseEntity' => $mandataire,
            'url_back' => $this->generateUrl('admin_mandataires'),
        ]);
    }


    /**
     * @Route("user/mandataire/delete/{id}", name="user_mandataire_delete")
     */
    public function delete(
        MandataireEntity $mandataire,
        MandataireRepository $mandataireRepository
    ) {
        $user = $this->security->getUser();
        if ($mandataire && $mandataire->isOwnBy($user)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mandataire);
            $em->flush();
        }
        return $this->redirectToRoute('admin_mandataires');
    }
}
