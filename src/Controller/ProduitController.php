<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\ProduitTranslation;
use App\Form\ProduitType;
use App\Repository\LocaleRepository;
use App\Repository\ProduitRepository;
use App\Repository\ProduitTranslationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'produit')]
    public function index(): Response
    {
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }

    #[Route('/produit/add', name: 'produit_add')]
    public function add(Request $request, LocaleRepository $localeRepository, ProduitRepository $produitRepository, ProduitTranslationRepository $produitTranslationRepository)
    {
        // $produit = new Produit();
        $produit = $produitRepository->find(1);
        if (!$produit->getProduitTranslations()) {
            $produit->setProduitTranslations(new ArrayCollection());
        }

        $locales = $localeRepository->findAll();
        $locale = 1;

        foreach ($locales as $locale) {
            $produitTranslation = new ProduitTranslation();
            $produitTranslation->setLocale($locale);

            $produit->getProduitTranslations()->add($produitTranslation);
        }

        // $produitId = $request->get('produitId');
        // if ($produitId) {
        //     $produitTranslations = $produitTranslationRepository->findBy(['produit_id' => $produitId, 'locale_id' => $locale,]);
        //     foreach ($produitTranslations as $produitTranslation) {
        //         $produit->getProduitTranslations()->add($produitTranslation);
        //     }
        // }

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        dump($request);

        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render('produit/add.html.twig', [
            'form' => $form->createView(),
            'locales' => $locales,
        ]);
    }
}
