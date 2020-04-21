<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class UserGroupeController extends AbstractController
{
    /**
     * @Route("admin/usergroupes", name="admin_usergroupes")
     */
    public function index()
    {
        return $this->render('user_groupe/index.html.twig', [
            'controller_name' => 'UserGroupeController',
        ]);
    }
}
