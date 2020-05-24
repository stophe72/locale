<?php

namespace App\Controller;

use App\Entity\MajeurEntity;
use App\Form\AdresseType;
use App\Form\ContactType;
use App\Form\JugementType;
use App\Form\MajeurAdresseContactType;
use App\Form\MajeurType;
use App\Form\TribunalType;
use App\Models\MajeurAdresseContact;
use App\Repository\DonneeBancaireRepository;
use App\Repository\MajeurRepository;
use App\Repository\MandataireRepository;
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
    public function edit(Request $request, MajeurEntity $majeur, MandataireRepository $mandataireRepository)
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
    public function show(MajeurEntity $majeur, DonneeBancaireRepository $donneeBancaireRepository)
    {
        if ($this->isInSameGroupe($majeur)) {
            $dbs = $donneeBancaireRepository->findBy(['majeur' => $majeur,]);
            return $this->render(
                'majeur/show.html.twig',
                [
                    'donneeBancaires' => $dbs,
                    'majeur' => $majeur,
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
     * @Route("user/majeur/{slug}/editJugement", name="user_majeur_edit_jugement")
     */
    public function editTribunal(MajeurEntity $majeur, Request $request)
    {
        $form = $this->createForm(JugementType::class, $majeur->getJugement());
        $form->handleRequest($request);

        return $this->doRequest($form, 'majeur/majeur_edit_jugement.html.twig', $majeur, $majeur->__toString() . ' - Mesure');
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
