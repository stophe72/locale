<?php

namespace App\Controller;

use App\Entity\UserGroupeEntity;
use App\Form\UserGroupeType;
use App\Repository\UserGroupeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class UserGroupeController extends AbstractController
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
     * @Route("admin/usergroupes", name="admin_usergroupes")
     */
    public function index(UserGroupeRepository $userGroupeRepository)
    {
        $user = $this->security->getUser();

        $groupes = $userGroupeRepository->findBy(
            [
                'user' => $user->getId(),
            ]
        );

        return $this->render('user_groupe/index.html.twig', [
            'usergroupes' => $groupes,
            'page_title' => 'Liste des groupes d\'utilisateurs',
        ]);
    }

    /**
     * @Route("admin/usergroupe/add/", name="admin_usergroupe_add")
     */
    public function add(Request $request)
    {
        $groupe = new UserGroupeEntity();

        $form = $this->createForm(UserGroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();

            return $this->redirectToRoute('admin_usergroupes');
        }

        return $this->render('user_groupe/new_or_edit.html.twig', [
            'page_title' => 'Ajouter un groupe d\'utilsateurs',
            'form' => $form->createView(),
            'baseEntity' => $groupe,
            'url_back' => $this->generateUrl('admin_usergroupes'),
        ]);
    }

    /**
     * @Route("admin/usergroupe/edit/{id}", name="admin_usergroupe_edit")
     */
    public function edit(UserGroupeEntity $userGroupe, Request $request)
    {
        $form = $this->createForm(UserGroupeType::class, $userGroupe);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($userGroupe->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userGroupe);
            $em->flush();

            return $this->redirectToRoute('admin_usergroupes');
        }

        return $this->render('user_groupe/new_or_edit.html.twig', [
            'page_title' => 'Editer un groupe d\'utilisateurs',
            'form' => $form->createView(),
            'baseEntity' => $userGroupe,
            'url_back' => $this->generateUrl('admin_usergroupes'),
        ]);
    }
}
