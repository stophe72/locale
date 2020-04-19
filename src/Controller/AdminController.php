<?php

namespace App\Controller;

use App\Entity\UserEntity;
use App\Form\UserType;
use App\Repository\AdresseRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    const TPL_USER_INDEX       = 'admin/user_index.html.twig';
    const TPL_USER_NEW_OR_EDIT = 'admin/user_new_or_edit.html.twig';

    const ROUTE_USERS = 'admin_users';

    /**
     * @Route("admin/users", name="admin_users")
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findBy([], ['email' => 'ASC']);

        return $this->render(
            self::TPL_USER_INDEX,
            [
                'users' => $users,
                'page_title' => 'Utilisateurs',
            ]
        );
    }

    /**
     * @Route("admin/user/add", name="admin_user_add")
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new UserEntity();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->isAdministrateur()) {
                $user->setRoles(['ROLE_ADMIN']);
            }
            $pwd      = $form['password']->getData();
            $password = $passwordEncoder->encodePassword($user, $pwd);
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute(self::ROUTE_USERS);
        }
        return $this->render(
            self::TPL_USER_NEW_OR_EDIT,
            [
                'form' => $form->createView(),
                'page_title' => 'Ajouter un utilisateur',
                'baseEntity' => $user,
                'url_back' => $this->generateUrl(self::ROUTE_USERS),
            ]
        );
    }

    /**
     * @Route("admin/user/edit/{id}", name="admin_user_edit")
     */
    public function editUser(UserEntity $user, Request $request, UserPasswordEncoderInterface $passwordEncoder, AdresseRepository $adresseRepository)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $user->setAdministrateur(true);
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->isAdministrateur()) {
                $user->setRoles(['ROLE_ADMIN']);
            }
            $pwd      = $form['password']->getData();
            $password = $passwordEncoder->encodePassword($user, $pwd);
            $user->setPassword($password);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(self::ROUTE_USERS);
        }
        return $this->render(
            self::TPL_USER_NEW_OR_EDIT,
            [
                'form' => $form->createView(),
                'page_title' => 'Editer un utilisateur',
                'baseEntity' => $user,
                'url_back' => $this->generateUrl(self::ROUTE_USERS),
            ]
        );
    }

    /**
     * @Route("admin/user/delete/{id}", name="admin_user_delete")
     */
    public function deleteUser(UserEntity $user, Request $request, UserRepository $userRepository)
    {
        $u = $userRepository->findById($user->getId());
        if ($u) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($u);
            $em->flush();
        }
        return $this->redirectToRoute(self::ROUTE_USERS);
    }

    /**
     * @Route("admin/user/show/{id}", name="admin_user_show")
     */
    public function showUser(UserEntity $user, UserRepository $userRepository)
    {
        return $this->render(
            'admin/user_show.html.twig',
            [
                'user' => $user,
                'page_title' => 'Détails d\'un utilisateur',
                'url_back'   => $this->generateUrl('admin_users'),
            ]
        );
    }
}
