<?php

namespace App\Controller;

use App\Entity\MajeurEntity;
use App\Entity\MandataireEntity;
use App\Entity\VisiteEntity;
use App\Repository\GroupeRepository;
use App\Repository\MajeurRepository;
use App\Repository\MandataireRepository;
use App\Repository\VisiteRepository;
use App\Util\Calendrier;
use App\Util\Util;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class VisiteController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * Constructeur
     *
     * @param Security         $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("user/visites/{id}/{annee?}", name="user_visites")
     * @param PaginatorInterface $paginator
     * @param VisiteRepository   $visiteRepository
     * @return Response
     */
    public function index(MajeurEntity $majeur, ?int $annee, MandataireRepository $mandataireRepository, VisiteRepository $visiteRepository)
    {
        $user = $this->security->getUser();

        $mandataire = $mandataireRepository->findOneBy(['user' => $user->getId()]);

        if (!$annee || $annee < 2000 || $annee > 2050) {
            $annee = intval(date('Y'));
        }
        $visites = $visiteRepository->getFromMajeurAndAnnee($mandataire, $majeur, $annee);
        $calendrier = new Calendrier($visites, $annee);

        return $this->render(
            'visite/calendrier.html.twig',
            [
                'majeur' => $majeur,
                'page_title' => 'Calendrier des visites',
                'calendrier' => $calendrier->generate(),
                'annee' => $annee,
                'url_back' => $this->generateUrl('user_majeurs'),
            ]
        );
    }

    /**
     * @Route("user/visite/ajaxVisiteToggleVisite", name="ajax_visite_toggle_visite")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxVisiteToggleVisite(Request $request, MandataireRepository $mandataireRepository, MajeurRepository $majeurRepository)
    {
        $user = $this->security->getUser();
        $em = $this->getDoctrine()->getManager();
        $mandataire = $mandataireRepository->findOneBy(['user' => $user->getId()]);

        $data = 0;
        $jour = $request->get('jour', 0);
        $mois = $request->get('mois', 0);
        $annee = $request->get('annee', 0);
        $majeurId = $request->get('majeurId', 0);

        $majeur = $majeurRepository->find($majeurId);

        if (
            $majeur && $mandataire
            && $majeur->getGroupe() == $mandataire->getGroupe()
            && Util::verifyDate($jour . '/' . $mois . '/' . $annee)
        ) {
            $date = new DateTime();
            $date->setDate($annee, $mois, $jour);

            $visiteRepo = $em->getRepository(VisiteEntity::class);
            $visite = $visiteRepo->findBy(['majeur' => $majeur, 'date' => $date]);
            if ($visite) {
                $em->remove($visite[0]);

                $data = 1;
            } else {
                $visite = new VisiteEntity();
                $visite->setMajeur($majeur);
                $visite->setDate($date);

                $em->persist($visite);

                $data = 2;
            }
            $em->flush();
        }

        return new JsonResponse(
            [
                'data' => $data,
            ]
        );
    }
}
