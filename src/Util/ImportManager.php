<?php

namespace App\Util;

use App\Entity\CompteGestionEntity;
use App\Entity\MajeurEntity;
use App\Repository\ImportOperationRepository;
use DateTime;

class ImportManager
{
    public function parseCsv(MajeurEntity $majeur, array $file, ImportOperationRepository $importOperationRepository)
    {
        $cgs = [];
        // $cgsKo = [];
        foreach ($file as $row) {
            $data = str_getcsv($row);

            $date = DateTime::createFromFormat('d/m/Y', $data[0]);
            $tos = $importOperationRepository->findByMatchLibelle($data[1]);

            $compteGestion = new CompteGestionEntity();
            $compteGestion->setDate($date);
            $compteGestion->setMajeur($majeur);
            $compteGestion->setLibelle($data[1]);
            $compteGestion->setMontant($data[2]);

            if (count($tos) == 1) {
                $compteGestion->setTypeOperation($tos[0]->getTypeOperation());
            }

            $cgs[] = $compteGestion;
        }
        return $cgs;
    }
}
