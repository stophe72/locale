<?php

namespace App\Controller;

use App\Entity\NoteDeFraisEntity;
use App\Form\NoteDeFraisType;
use App\Repository\NoteDeFraisEntityRepository;
use App\Repository\TypeFraisRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class NoteDeFraisController extends AbstractController
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
     * @Route("user/notesdefrais", name="user_notesdefrais")
     */
    public function index(
        PaginatorInterface $paginator,
        Request $request,
        NoteDeFraisEntityRepository $noteDeFraisEntityRepository
    ) {
        $user = $this->security->getUser();
        $startPage = $request->get('page', 1);
        $pagination = $paginator->paginate(
            $noteDeFraisEntityRepository->getQueryBuilder($user),
            $startPage,
            12,
            [
                'defaultSortFieldName' => 'ndf.date',
                'defaultSortDirection' => 'desc'
            ]
        );

        return $this->render('note_de_frais/index.html.twig', [
            'pagination' => $pagination,
            'page_title' => "Liste des notes de frais"
        ]);
    }

    /**
     * @Route("user/notesdefrais/add", name="user_ndf_add")
     */
    public function add(Request $request, TypeFraisRepository $typeFraisRepository)
    {
        $noteDeFrais = new NoteDeFraisEntity();

        $typesFrais = $typeFraisRepository->findBy([], ['libelle' => 'ASC']);

        $form = $this->createForm(NoteDeFraisType::class, $noteDeFrais, ['typesFrais' => $typesFrais]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($noteDeFrais);
            $em->flush();

            return $this->redirectToRoute('user_notesdefrais');
        }

        return $this->render(
            'note_de_frais/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouvelle note de frais',
                'baseEntity' => $noteDeFrais,
                'url_back' => 'user_notesdefrais',
            ]
        );
    }

    /**
     * @Route("user/notesdefrais/edit/{id}", name="user_ndf_edit")
     */
    public function edit(
        NoteDeFraisEntity $noteDeFrais,
        Request $request
    ) {
        $form = $this->createForm(NoteDeFraisType::class, $noteDeFrais);
        $form->handleRequest($request);

        $user = $this->security->getUser();

        if ($noteDeFrais->isOwnBy($user) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_notesdefrais');
        }

        return $this->render(
            'note_de_frais/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Modifier une note de frais',
                'baseEntity' => $noteDeFrais,
                'url_back' => 'user_notesdefrais',
            ]
        );
    }
}
