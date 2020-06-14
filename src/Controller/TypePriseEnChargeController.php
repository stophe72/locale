<?php

namespace App\Controller;

use App\Entity\TypePriseEnChargeEntity;
use App\Form\TypePriseEnChargeType;
use App\Repository\MandataireRepository;
use App\Repository\TypePriseEnChargeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TypePriseEnChargeController extends AbstractController
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

    private function isInSameGroupe(TypePriseEnChargeEntity $typePriseEnCharge)
    {
        return $typePriseEnCharge && $this->getMandataire()->getGroupe() == $typePriseEnCharge->getGroupe();
    }

    /**
     * @Route("user/typepriseencharges", name="user_typespriseencharge")
     */
    public function index(TypePriseEnChargeRepository $typePriseEnChargeRepository)
    {
        return $this->render('type_prise_en_charge/index.html.twig', [
            'typePriseEnCharges' => $typePriseEnChargeRepository->findBy(['groupe' => $this->getMandataire()->getGroupe(),], ['libelle' => 'ASC']),
            'page_title' => 'Liste des types de prise en charge',
        ]);
    }

    /**
     * @Route("user/typepriseencharge/add", name="user_typepriseencharge_add")
     */
    public function add(Request $request)
    {
        $typePriseEnCharge = new TypePriseEnChargeEntity();
        $typePriseEnCharge->setGroupe($this->getMandataire()->getGroupe());
        $typePriseEnCharge->setSeuilAlerte(8);

        $form = $this->createForm(TypePriseEnChargeType::class, $typePriseEnCharge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typePriseEnCharge);
            $em->flush();

            return $this->redirectToRoute('user_typespriseencharge');
        }

        return $this->render(
            'type_prise_en_charge/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouveau type de prise en charge',
                'baseEntity' => $typePriseEnCharge,
                'url_back' => $this->generateUrl('user_typespriseencharge'),
            ]
        );
    }

    /**
     * @Route("user/typepriseencharge/edit/{id}", name="user_typepriseencharge_edit")
     */
    public function edit(TypePriseEnChargeEntity $typePriseEnCharge, Request $request)
    {
        $form = $this->createForm(TypePriseEnChargeType::class, $typePriseEnCharge);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($typePriseEnCharge) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_typespriseencharge');
        }

        return $this->render(
            'type_prise_en_charge/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un type de prise en charge',
                'baseEntity' => $typePriseEnCharge,
                'url_back'    => $this->generateUrl('user_typespriseencharge'),
            ]
        );
    }

    /**
     * @Route("user/typepriseencharge/ajaxCanDeletepriseEnCharge", name="ajaxCanDeletepriseEnCharge")
     */
    public function ajaxCanDeleteTypePriseEnCharge(
        Request $request,
        TypePriseEnChargeRepository $typePriseEnChargeRepository
    ) {
        $typePriseEnChargeId = $request->get('typePriseEnChargeId', -1);
        $count = $typePriseEnChargeRepository->countById($this->getMandataire(), $typePriseEnChargeId);

        return new JsonResponse(['data' => $count == 0]);
    }

    /**
     * @Route("user/typepriseencharge/delete/{id}", name="user_typepriseencharge_delete")
     */
    public function delete(
        TypePriseEnChargeEntity $typePriseEnCharge,
        TypePriseEnChargeRepository $typePriseEnChargeRepository
    ) {
        if ($this->isInSameGroupe($typePriseEnCharge)) {
            $count = $typePriseEnChargeRepository->countById($this->getMandataire(), $typePriseEnCharge->getId());
            if ($count == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($typePriseEnCharge);
                $em->flush();
            }
        }
        return $this->redirectToRoute('user_typespriseencharge');
    }
}
