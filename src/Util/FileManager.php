<?php

namespace App\Util;

use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function saveUploadedFile(UploadedFile $uploadFile, string $uploadPath)
    {
        $originalFilename = pathinfo($uploadFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadFile->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $a = $uploadFile->move(
                $uploadPath,
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            $this->logger->error($e->getMessage());
        }
        return $newFilename;
    }

    public function deleteFile(string $fichier, string $uploadPath)
    {
        $filesystem = new Filesystem();
        $filesystem->remove($uploadPath . $fichier);
    }
}
