<?php

namespace App\Controller;

use App\Entity\ContactExterneEntity;
use App\Entity\DecesEntity;
use App\Entity\JugementEntity;
use App\Entity\MajeurEntity;
use App\Entity\ParametreMissionEntity;
use App\Entity\PriseEnChargeEntity;
use App\Entity\TypePriseEnChargeEntity;
use App\Form\AdresseType;
use App\Form\ContactExterneType;
use App\Form\ContactType;
use App\Form\DecesType;
use App\Form\JugementType;
use App\Form\MajeurType;
use App\Form\ParametreMissionType;
use App\Form\PriseEnChargeType;
use App\Repository\ContactExterneRepository;
use App\Repository\DecesRepository;
use App\Repository\DonneeBancaireRepository;
use App\Repository\JugementRepository;
use App\Repository\MajeurRepository;
use App\Repository\MandataireRepository;
use App\Repository\ParametreMissionRepository;
use App\Repository\PriseEnChargeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MajeurController extends AbstractController
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

    private function isInSameGroupe(MajeurEntity $majeur)
    {
        return $majeur && $this->getMandataire()->getGroupe() == $majeur->getGroupe();
    }

    /**
     * @Route("user/majeurs", name="user_majeurs")
     */
    public function index(MajeurRepository $majeurRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $majeurs = $majeurRepository->findBy(['groupe' => $this->getMandataire()->getGroupe()], ['nom' => 'ASC']);

        return $this->render('majeur/index.html.twig', [
            'majeurs' => $majeurs,
            'page_title' => 'Liste des majeurs',
        ]);
    }

    /**
     * @Route("user/majeur/add", name="user_majeur_add")
     */
    public function add(Request $request)
    {
        $majeur = new MajeurEntity();
        $majeur->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(MajeurType::class, $majeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = $this->saveUploadedImage($imageFile);
                $majeur->setImage($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($majeur);
            $em->flush();

            return $this->redirectToRoute('user_majeurs');
        }
        return $this->render(
            'majeur/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Nouveau majeur',
                'baseEntity' => $majeur,
                'url_back'    => $this->generateUrl('user_majeurs'),
            ]
        );
    }

    /**
     * @Route("user/majeur/edit/{slug}", name="user_majeur_edit")
     */
    public function edit(Request $request, MajeurEntity $majeur)
    {
        $form = $this->createForm(MajeurType::class, $majeur);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($majeur) && $form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = $this->saveUploadedImage($imageFile);
                $majeur->setImage($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($majeur);
            $em->flush();

            return $this->redirectToRoute('user_majeurs');
        }

        return $this->render(
            'majeur/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Editer un majeur',
                'baseEntity' => $majeur,
                'url_back'    => $this->generateUrl('user_majeurs'),
            ]
        );
    }

    /**
     * @Route("user/majeur/ajaxMajeursGetByName", name="ajax_majeurs_get_by_name")
     */
    public function ajaxMajeursGetByName(Request $request, MajeurRepository $majeurRepository)
    {
        $name = $request->get('name');

        /** @var MajeurEntity[] $majeurs */
        $majeurs = $majeurRepository->findByName($name, $this->getMandataire());
        $a       = [];
        foreach ($majeurs as $majeur) {
            $a[] = [
                'value' => $majeur->getId(),
                'label' => $majeur->getNom() . ' ' . $majeur->getPrenom(),
            ];
        }
        return new JsonResponse($a);
    }

    /**
     * @Route("user/majeur/show/{slug}", name="user_majeur_show")
     */
    public function show(
        MajeurEntity $majeur,
        DonneeBancaireRepository $donneeBancaireRepository,
        DecesRepository $decesRepository,
        JugementRepository $jugementRepository,
        ParametreMissionRepository $parametreMissionRepository,
        ContactExterneRepository $contactExterneRepository,
        PriseEnChargeRepository $priseEnChargeRepository
    ) {
        if ($this->isInSameGroupe($majeur)) {
            $deces = $decesRepository->findOneBy(['majeur' => $majeur->getId()]);
            $jugement = $jugementRepository->findOneBy(['majeur' => $majeur->getId()]);
            $parametreMission = $parametreMissionRepository->findOneBy(['majeur' => $majeur->getId()]);
            $contactsExternes = $contactExterneRepository->findBy(['majeur' => $majeur->getId()]);
            $dbs = $donneeBancaireRepository->findBy(['majeur' => $majeur,]);
            $pecs = $priseEnChargeRepository->findBy(['majeur' => $majeur,]);

            return $this->render(
                'majeur/show.html.twig',
                [
                    'contactExternes' => $contactsExternes,
                    'donneeBancaires' => $dbs,
                    'prisesEnCharge' => $pecs,
                    'jugement' => $jugement,
                    'parametreMission' => $parametreMission,
                    'majeur' => $majeur,
                    'deces' => $deces,
                    'page_title' => 'Détails d\'un majeur',
                    'url_back'   => $this->generateUrl('user_majeurs'),
                ]
            );
        }
        return $this->redirectToRoute('user_majeurs');
    }

    private function saveUploadedImage($imageFile)
    {
        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $a = $imageFile->move(
                $this->getParameter('upload_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }
        return $newFilename;
    }

    /**
     * @Route("user/majeur/{slug}/addMesure", name="user_majeur_add_mesure")
     */
    public function addMesure(MajeurEntity $majeur, Request $request)
    {
        if (!$this->isInSameGroupe($majeur)) {
            return $this->redirectToRoute('user_majeurs');
        }
        $jugement = new JugementEntity();
        $jugement->setMajeur($majeur);

        $form = $this->createForm(JugementType::class, $jugement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jugement);
            $em->flush();

            return $this->redirectToRoute(
                'user_majeur_show',
                [
                    'slug' => $majeur->getSlug(),
                ]
            );
        }

        return $this->render(
            'majeur/majeur_edit_mesure.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => $majeur->__toString() . ' - Jugement',
                'baseEntity' => $majeur,
                'url_back' => $this->generateUrl(
                    'user_majeur_show',
                    [
                        'slug' => $majeur->getSlug(),
                    ]
                ),
            ]
        );
    }

    /**
     * @Route("user/majeur/{slug}/editMesure", name="user_majeur_edit_mesure")
     */
    public function editMesure(MajeurEntity $majeur, JugementEntity $jugement, Request $request)
    {
        $form = $this->createForm(JugementType::class, $jugement);
        $form->handleRequest($request);

        return $this->doRequest($form, 'majeur/majeur_edit_mesure.html.twig', $jugement->getMajeur(), $majeur->__toString() . ' - Jugement');
    }

    /**
     * @Route("user/majeur/{slug}/addContactExterne", name="user_majeur_add_contact_externe")
     */
    public function addContactExterne(MajeurEntity $majeur, Request $request)
    {
        if (!$this->isInSameGroupe($majeur)) {
            return $this->redirectToRoute('user_majeurs');
        }
        $contactExterne = new ContactExterneEntity();
        $contactExterne->setMajeur($majeur);

        $form = $this->createForm(ContactExterneType::class, $contactExterne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactExterne);
            $em->flush();

            return $this->redirectToRoute(
                'user_majeur_show',
                [
                    'slug' => $majeur->getSlug(),
                ]
            );
        }

        return $this->render(
            'majeur/majeur_edit_contact_externe.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => $majeur->__toString() . ' - Contact externe',
                'baseEntity' => $majeur,
                'url_back' => $this->generateUrl(
                    'user_majeur_show',
                    [
                        'slug' => $majeur->getSlug(),
                    ]
                ),
            ]
        );
    }

    /**
     * @Route("user/majeur/{slug}/editContactExterne", name="user_majeur_edit_contact_externe")
     */
    public function editContactExterne(MajeurEntity $majeur, ContactExterneEntity $contactExterne, Request $request)
    {
        $form = $this->createForm(ContactExterneType::class, $contactExterne);
        $form->handleRequest($request);

        return $this->doRequest($form, 'majeur/majeur_edit_contact_externe.html.twig', $contactExterne->getMajeur(), $majeur->__toString() . ' - Contact externe');
    }

    /**
     * @Route("user/majeur/deleteContactExterne/{id}", name="user_majeur_delete_contact_externe")
     */
    public function deleteContactExterne(ContactExterneEntity $contactExterne)
    {
        if (!$this->isInSameGroupe($contactExterne->getMajeur())) {
            return $this->redirectToRoute('user_majeurs');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($contactExterne);
        $em->flush();

        return $this->redirectToRoute(
            'user_majeur_show',
            [
                'slug' => $contactExterne->getMajeur()->getSlug(),
            ]
        );
    }

    /**
     * @Route("user/majeur/{slug}/addParametreMission", name="user_majeur_add_parametre_mission")
     */
    public function addParametreMission(MajeurEntity $majeur, Request $request)
    {
        if (!$this->isInSameGroupe($majeur)) {
            return $this->redirectToRoute('user_majeurs');
        }
        $pec = new ParametreMissionEntity();
        $pec->setMajeur($majeur);

        $form = $this->createForm(ParametreMissionType::class, $pec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pec);
            $em->flush();

            return $this->redirectToRoute(
                'user_majeur_show',
                [
                    'slug' => $majeur->getSlug(),
                ]
            );
        }

        return $this->render(
            'majeur/majeur_edit_parametre_mission.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => $majeur->__toString() . ' - Paramètres de la mission',
                'baseEntity' => $majeur,
                'url_back' => $this->generateUrl(
                    'user_majeur_show',
                    [
                        'slug' => $majeur->getSlug(),
                    ]
                ),
            ]
        );
    }

    /**
     * @Route("user/majeur/{slug}/editParametreMission", name="user_majeur_edit_parametre_mission")
     */
    public function editParametreMission(MajeurEntity $majeur, ParametreMissionEntity $parametreMission, Request $request)
    {
        $form = $this->createForm(ParametreMissionType::class, $parametreMission);
        $form->handleRequest($request);

        return $this->doRequest($form, 'majeur/majeur_edit_parametre_mission.html.twig', $parametreMission->getMajeur(), $majeur->__toString() . ' - Paramètres de la mission');
    }

    /**
     * @Route("user/majeur/{slug}/addPriseEnCharge", name="user_majeur_add_prise_en_charge")
     */
    public function addPriseEnCharge(MajeurEntity $majeur, Request $request)
    {
        if (!$this->isInSameGroupe($majeur)) {
            return $this->redirectToRoute('user_majeurs');
        }
        $pec = new PriseEnChargeEntity();
        $pec->setMajeur($majeur);

        $form = $this->createForm(PriseEnChargeType::class, $pec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pec);
            $em->flush();

            return $this->redirectToRoute(
                'user_majeur_show',
                [
                    'slug' => $majeur->getSlug(),
                ]
            );
        }

        return $this->render(
            'majeur/majeur_edit_prise_en_charge.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => $majeur->__toString() . ' - Prises en charge',
                'baseEntity' => $majeur,
                'url_back' => $this->generateUrl(
                    'user_majeur_show',
                    [
                        'slug' => $majeur->getSlug(),
                    ]
                ),
            ]
        );
    }

    /**
     * @Route("user/majeur/{slug}/editPriseEnCharge", name="user_majeur_edit_prise_en_charge")
     */
    public function editPriseEnCharge(MajeurEntity $majeur, PriseEnChargeEntity $priseEnCharge, Request $request)
    {
        $form = $this->createForm(PriseEnChargeType::class, $priseEnCharge);
        $form->handleRequest($request);

        return $this->doRequest($form, 'majeur/majeur_edit_prise_en_charge.html.twig', $priseEnCharge->getMajeur(), $majeur->__toString() . ' - Prise en charge');
    }

    /**
     * @Route("user/majeur/deletePriseEnCharge/{id}", name="user_majeur_delete_prise_en_charge")
     */
    public function deletePriseEnCharge(PriseEnChargeEntity $priseEnCharge)
    {
        if (!$this->isInSameGroupe($priseEnCharge->getMajeur())) {
            return $this->redirectToRoute('user_majeurs');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($priseEnCharge);
        $em->flush();

        return $this->redirectToRoute(
            'user_majeur_show',
            [
                'slug' => $priseEnCharge->getMajeur()->getSlug(),
            ]
        );
    }

    /**
     * @Route("user/majeur/{slug}/editAdresse", name="user_majeur_edit_adresse")
     */
    public function editAdresse(MajeurEntity $majeur, Request $request)
    {
        $form = $this->createForm(AdresseType::class, $majeur->getAdresse());
        $form->handleRequest($request);

        return $this->doRequest($form, 'majeur/majeur_edit_adresse.html.twig', $majeur, $majeur->__toString() . ' - Adresse');
    }

    /**
     * @Route("user/majeur/{slug}/editContact", name="user_majeur_edit_contact")
     */
    public function editContact(MajeurEntity $majeur, Request $request)
    {
        $form = $this->createForm(ContactType::class, $majeur->getContact());
        $form->handleRequest($request);

        return $this->doRequest($form, 'majeur/majeur_edit_contact.html.twig', $majeur, $majeur->__toString() . ' - Contact');
    }

    /**
     * @Route("user/majeur/{slug}/addDeces", name="user_majeur_add_deces")
     */
    public function addDeces(MajeurEntity $majeur, Request $request)
    {
        if (!$this->isInSameGroupe($majeur)) {
            return $this->redirectToRoute('user_majeurs');
        }
        $deces = new DecesEntity();
        $deces->setMajeur($majeur);

        $form = $this->createForm(DecesType::class, $deces);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($deces);
            $em->flush();

            return $this->redirectToRoute(
                'user_majeur_show',
                [
                    'slug' => $majeur->getSlug(),
                ]
            );
        }

        return $this->render(
            'majeur/majeur_edit_deces.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => $majeur->__toString() . ' - Décès',
                'baseEntity' => $majeur,
                'url_back' => $this->generateUrl(
                    'user_majeur_show',
                    [
                        'slug' => $majeur->getSlug(),
                    ]
                ),
            ]
        );
    }

    /**
     * @Route("user/majeur/{slug}/editDeces", name="user_majeur_edit_deces")
     */
    public function editDeces(MajeurEntity $majeur, DecesEntity $deces, Request $request)
    {
        if (!$this->isInSameGroupe($deces->getMajeur())) {
            return $this->redirectToRoute('user_majeurs');
        }
        $form = $this->createForm(DecesType::class, $deces);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($majeur) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'user_majeur_show',
                [
                    'slug' => $majeur->getSlug(),
                ]
            );
        }

        return $this->render(
            'majeur/majeur_edit_deces.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => $majeur->__toString() . ' - Décès',
                'baseEntity' => $majeur,
                'url_back' => $this->generateUrl(
                    'user_majeur_show',
                    [
                        'slug' => $majeur->getSlug(),
                    ]
                ),
            ]
        );
    }

    private function doRequest(FormInterface $form, string $template, MajeurEntity $majeur, string $titre)
    {
        if ($this->isInSameGroupe($majeur) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'user_majeur_show',
                [
                    'slug' => $majeur->getSlug(),
                ]
            );
        }

        return $this->render(
            $template,
            [
                'form' => $form->createView(),
                'page_title' => $titre,
                'baseEntity' => $majeur,
                'url_back' => $this->generateUrl(
                    'user_majeur_show',
                    [
                        'slug' => $majeur->getSlug(),
                    ]
                ),
            ]
        );
    }
}
