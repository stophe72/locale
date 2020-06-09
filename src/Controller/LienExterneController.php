<?php

namespace App\Controller;

use App\Repository\LienExterneRepository;
use App\Repository\MandataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class LienExterneController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var MandataireRepository
     */
    private $mandataireRepository;

    public function __construct(Security $security, MandataireRepository $mandataireRepository)
    {
        $this->security = $security;
        $this->mandataireRepository = $mandataireRepository;
    }

    private function getMandataire()
    {
        $user = $this->security->getUser();
        return $this->mandataireRepository->findOneBy(['user' => $user->getId()]);
    }

    /**
     * Route non exposée, utilisée pour générer le menu dynamiquement à partir des liens en table
     */
    public function lienExternesMenu(LienExterneRepository $lienExterneRepository)
    {
        $mandataire = $this->getMandataire();
        $mandataire->getGroupe();
        $liens = $lienExterneRepository->findBy(['groupe' => $this->getMandataire()->getGroupe()], ['libelle' => 'ASC']);

        return $this->render(
            'lien_externe/liste_menu.html.twig',
            [
                'liens' => $liens,
            ]
        );
    }

    /**
     * @Route("user/lienexternes", name="user_lienexternes")
     */
    public function index(LienExterneRepository $lienExterneRepository)
    {
        $liens = $lienExterneRepository->findBy(['groupe' => $this->getMandataire()->getGroupe()], ['libelle' => 'ASC']);

        return $this->render('lien_externe/index.html.twig', [
            'lienExternes' => $liens,
            'page_title' => 'Liste des liens externes',
        ]);
    }
}
