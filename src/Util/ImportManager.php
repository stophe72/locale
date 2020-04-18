<?php

namespace App\Util;

use App\Entity\CompteGestionEntity;
use App\Entity\DonneeBancaireEntity;
use App\Form\DonneeBancaireType;
use App\Repository\ImportOperationRepository;
use DateTime;

class ImportManager
{
    const DEFAULT_DATE = '01/01/1970';
    const DEFAULT_LIBELLE = '--- indeterminé ---';

    public function parseCsv(DonneeBancaireEntity $donneeBancaire, array $file, ImportOperationRepository $importOperationRepository)
    {
        $ios = $importOperationRepository->findAll();
        $cgs = [];
        $cgsKo = [];
        foreach ($file as $row) {
            $data = str_getcsv($row);

            $compteGestion = $this->getNewWithDefaults($donneeBancaire);

            if ($this->isDateValide($data[0])) {
                $date = DateTime::createFromFormat('d/m/Y', $data[0]);
                $compteGestion->setDate($date);
            }

            $libelle = trim($data[1]);
            if (!empty($libelle)) {
                $compteGestion->setLibelle($libelle);
            }

            if (is_numeric($data[2])) {
                $compteGestion->setMontant($data[2]);
            }

            $this->setTypeOperation($compteGestion, $ios, $libelle);

            if ($this->isCompteOperationValide($compteGestion)) {
                $cgs[] = $compteGestion;
            } else {
                $cgsKo[] = $compteGestion;
            }
        }

        return [
            'ok' => $cgs,
            'ko' => $cgsKo,
        ];
    }

    private function getNewWithDefaults(DonneeBancaireEntity $donneeBancaire)
    {
        $date = DateTime::createFromFormat('d/m/Y', self::DEFAULT_DATE);

        $compteGestion = new CompteGestionEntity();
        $compteGestion->setDonneeBancaire($donneeBancaire);
        $compteGestion->setDate($date);
        $compteGestion->setLibelle(self::DEFAULT_LIBELLE);
        $compteGestion->setMontant(0);

        return $compteGestion;
    }

    private function isCompteOperationValide(CompteGestionEntity $compteGestion)
    {
        return $compteGestion->getDate() != new DateTime('01/01/1970')
            && $compteGestion->getTypeOperation() != null
            && $compteGestion->getLibelle() != '--- indéterminé ---';
    }

    private function setTypeOperation(CompteGestionEntity $compteGestion, array $ios, string $libelle)
    {
        foreach ($ios as $io) {
            if (strpos($libelle, $io->getLibelle()) !== false) {
                $compteGestion->setTypeOperation($io->getTypeOperation());
                $compteGestion->setNature($io->getNature());

                return;
            }
        }
    }

    private function isDateValide($dateString)
    {
        list($d, $m, $y) = explode('/', $dateString);

        return checkdate($m, $d, $y);
    }
}
