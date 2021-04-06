<?php

namespace App\Controller;

use App\Entity\MajeurEntity;
use App\Entity\VisiteEntity;
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
    const VISITE_EFFACER      = 0;
    const VISITE_PRESENT      = 1;
    const VISITE_ABSENT       = 2;
    const VISITE_TOUT_EFFACER = 3;

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

    private function isInSameGroupe(MajeurEntity $majeur)
    {
        return $majeur && $this->getMandataire()->getGroupe() == $majeur->getGroupe();
    }

    /**
     * @Route("user/visites/{slug}/{annee?}", name="user_visites")
     * @param PaginatorInterface $paginator
     * @param VisiteRepository   $visiteRepository
     * @return Response
     */
    public function index(
        MajeurEntity $majeur,
        ?int $annee,
        VisiteRepository $visiteRepository
    ) {
        if ($this->getMandataire()->getGroupe() != $majeur->getGroupe()) {
            return $this->redirectToRoute('user_majeurs');
        }
        if (!$annee || $annee < 2000 || $annee > 2050) {
            $annee = intval(date('Y'));
        }
        $visites = $visiteRepository->getFromMajeurAndAnnee($this->getMandataire(), $majeur, $annee);
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
     * @Route("user/visite/ajaxVisiteToutEffacer", name="ajax_visite_tout_effacer")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxVisiteToutEffacer(Request $request, MajeurRepository $majeurRepository, VisiteRepository $visiteRepository)
    {
        $majeurId = $request->get('majeurId');
        $annee = $request->get('annee');

        $majeur = $majeurRepository->find($majeurId);

        if (!$majeur || !$this->isInSameGroupe($majeur)) {
            return new JsonResponse(['success' => false]);
        }

        $visiteRepository->effacerVisitesForMajeuraAndAnnee($majeur, $annee);

        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("user/visite/ajaxVisiteToggleVisite", name="ajax_visite_toggle_visite")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxVisiteToggleVisite(Request $request, MajeurRepository $majeurRepository)
    {
        $em = $this->getDoctrine()->getManager();

        $data = -1;
        $jour = $request->get('jour', 0);
        $mois = $request->get('mois', 0);
        $annee = $request->get('annee', 0);
        $presence = $request->get('presence', 0);
        $majeurId = $request->get('majeurId', 0);

        $majeur = $majeurRepository->find($majeurId);

        if (
            $this->isInSameGroupe($majeur)
            && Util::verifyDate($jour . '/' . $mois . '/' . $annee)
        ) {
            $date = new DateTime();
            $date->setDate($annee, $mois, $jour);

            $visiteRepo = $em->getRepository(VisiteEntity::class);
            /** @var VisiteEntity */
            $visite = $visiteRepo->findOneBy(['majeur' => $majeur, 'date' => $date]);

            if ($visite) {
                switch ($presence) {
                    case self::VISITE_EFFACER:
                        $data = $presence;
                        $em->remove($visite);
                        break;
                    case self::VISITE_PRESENT:
                    case self::VISITE_ABSENT:
                        $data = $presence;
                        $visite->setPresence($presence);
                        break;
                    default:
                        $data = -1;
                        break;
                }
            } else {
                $visite = new VisiteEntity();
                $visite->setMajeur($majeur);
                $visite->setDate($date);
                switch ($presence) {
                    case self::VISITE_ABSENT:
                    case self::VISITE_PRESENT:
                        $data = $presence;
                        $visite->setPresence($presence);
                        $em->persist($visite);
                        break;
                    default:
                        $data = -1;
                        break;
                }
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
