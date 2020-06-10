<?php

namespace App\Controller;

use App\Entity\DocumentEntity;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use App\Repository\MandataireRepository;
use App\Util\FileManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DocumentController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var MandataireRepository
     */
    private $mandataireRepository;

    private $fileManager;

    public function __construct(Security $security, MandataireRepository $mandataireRepository)
    {
        $this->security = $security;
        $this->mandataireRepository = $mandataireRepository;
        $this->fileManager = new FileManager();
    }

    private function getMandataire()
    {
        $user = $this->security->getUser();
        return $this->mandataireRepository->findOneBy(['user' => $user->getId()]);
    }

    private function isInSameGroupe(DocumentEntity $document)
    {
        return $document && $this->getMandataire()->getGroupe() == $document->getGroupe();
    }

    /**
     * @Route("user/documents", name="user_documents")
     */
    public function index(DocumentRepository $documentRepository)
    {
        $documents = $documentRepository->findBy(['groupe' => $this->getMandataire()->getGroupe()], ['libelle' => 'ASC']);

        return $this->render('document/index.html.twig', [
            'documents' => $documents,
            'page_title' => 'Liste des documents',
        ]);
    }

    /**
     * @Route("user/document/add", name="user_document_add")
     */
    public function add(Request $request)
    {
        $document = new DocumentEntity();
        $document->setGroupe($this->getMandataire()->getGroupe());

        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $docFile */
            $docFile = $form->get('fichier')->getData();
            if ($docFile) {
                $document->setFichier($this->fileManager->saveUploadedFile($docFile, $this->getParameter('upload_doc_directory')));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute('user_documents');
        }

        return $this->render(
            'document/new_or_edit.html.twig',
            [
                'form' => $form->createView(),
                'page_title' => 'Nouveau document',
                'baseEntity' => $document,
                'url_back' => $this->generateUrl('user_documents'),
            ]
        );
    }

    /**
     * @Route("user/document/edit/{id}", name="user_document_edit")
     */
    public function edit(DocumentEntity $document, Request $request, DocumentRepository $documentRepository)
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($this->isInSameGroupe($document) && $form->isSubmitted() && $form->isValid()) {
            $currentDoc = $documentRepository->find($document->getId());
            $this->fileManager->deleteFile($currentDoc->getFichier(), $this->getParameter('upload_doc_directory'));
            /** @var UploadedFile $docFile */
            $docFile = $form->get('fichier')->getData();
            if ($docFile) {
                $document->setFichier($this->fileManager->saveUploadedFile($docFile, $this->getParameter('upload_doc_directory')));
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_documents');
        }

        return $this->render(
            'document/new_or_edit.html.twig',
            [
                'form'        => $form->createView(),
                'page_title'  => 'Modifier un document',
                'baseEntity' => $document,
                'url_back'    => $this->generateUrl('user_documents'),
            ]
        );
    }

    /**
     * @Route("user/document/delete/{id}", name="user_document_delete")
     */
    public function delete(DocumentEntity $document)
    {
        if ($this->isInSameGroupe($document)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);
            $em->flush();

            $this->fileManager->deleteFile($document->getFichier(), $this->getParameter('upload_doc_directory'));
        }
        return $this->redirectToRoute('user_documents');
    }
}
