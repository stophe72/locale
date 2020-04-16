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
        $ios = $importOperationRepository->findAll();
        $cgs = [];
        $cgsKo = [];
        $result = [];
        foreach ($file as $row) {
            $invalide = false;
            $data = str_getcsv($row);

            $compteGestion = new CompteGestionEntity();
            $compteGestion->setMajeur($majeur);

            if ($this->isDateValide($data[0])) {
                $date = DateTime::createFromFormat('d/m/Y', $data[0]);
                $compteGestion->setDate($date);
            } else {
                $invalide = true;
                $compteGestion->setDate(new DateTime('01/01/1970'));
            }

            $libelle = trim($data[1]);
            if (empty($libelle)) {
                $invalide = true;
                $compteGestion->setLibelle('--- vide ---');
            } else {
                $compteGestion->setLibelle($libelle);
            }

            if (is_numeric($data[2])) {
                $compteGestion->setMontant($data[2]);
            } else {
                $invalide = true;
            }

            $toFound = false;
            foreach ($ios as $io) {
                if (strpos($data[1], $io->getLibelle()) !== false) {
                    $compteGestion->setTypeOperation($io->getTypeOperation());
                    $compteGestion->setNature($io->getNature());
                    $toFound = true;
                    break;
                }
            }

            if ($invalide || !$toFound) {
                $cgsKo[] = $compteGestion;
            } else {
                $cgs[] = $compteGestion;
            }
        }
        $result['ok'] = $cgs;
        $result['ko'] = $cgsKo;

        return $result;
    }

    private function isDateValide($dateString)
    {
        list($d, $m, $y) = explode('/', $dateString);

        return checkdate($m, $d, $y);
    }
}
