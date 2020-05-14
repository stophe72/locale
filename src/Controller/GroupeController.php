<?php

namespace App\Controller;

use App\Entity\GroupeEntity;
use App\Form\GroupeType;
use App\Repository\GroupeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class GroupeController extends AbstractController
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
     * @Route("admin/groupes", name="admin_groupes")
     */
    public function index(GroupeRepository $GroupeRepository)
    {
        $user = $this->security->getUser();

        $groupes = $GroupeRepository->findBy(
            [
                'user' => $user->getId(),
            ]
        );

        return $this->render('groupe/index.html.twig', [
            'groupes' => $groupes,
            'page_title' => 'Liste des groupes de mandataires',
        ]);
    }

    /**
     * @Route("admin/groupe/add/", name="admin_groupe_add")
     */
    public function add(Request $request)
    {
        $groupe = new GroupeEntity();

        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();

            return $this->redirectToRoute('admin_groupes');
        }

        return $this->render('groupe/new_or_edit.html.twig', [
            'page_title' => 'Ajouter un groupe de mandataires',
            'form' => $form->createView(),
            'baseEntity' => $groupe,
            'url_back' => $this->generateUrl('admin_groupes'),
        ]);
    }

    /**
     * @Route("admin/groupe/edit/{id}", name="admin_groupe_edit")
     */
    public function edit(GroupeEntity $Groupe, Request $request)
    {
        $form = $this->createForm(GroupeType::class, $Groupe);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($Groupe->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Groupe);
            $em->flush();

            return $this->redirectToRoute('admin_groupes');
        }

        return $this->render('groupe/new_or_edit.html.twig', [
            'page_title' => 'Editer un groupe de mandataires',
            'form' => $form->createView(),
            'baseEntity' => $Groupe,
            'url_back' => $this->generateUrl('admin_groupes'),
        ]);
    }
}
