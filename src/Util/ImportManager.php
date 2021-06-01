<?php

namespace App\Util;

use App\Entity\CompteGestionEntity;
use App\Entity\DonneeBancaireEntity;
use App\Repository\ImportOperationRepository;
use DateTime;

class ImportManager
{
    public function parseCsv(
        DonneeBancaireEntity $donneeBancaire,
        array $file,
        ImportOperationRepository $importOperationRepository
    ) {
        $ios = $importOperationRepository->findAll();
        $cgs = [];
        foreach ($file as $row) {
            $data = str_getcsv($row);

            if (!count($data) == 3) {
                continue;
            }
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

            $cgs[] = $compteGestion;
        }

        return $cgs;
    }

    private function getNewWithDefaults(DonneeBancaireEntity $donneeBancaire)
    {
        $compteGestion = new CompteGestionEntity();
        $compteGestion->setDonneeBancaire($donneeBancaire);
        $compteGestion->setDate(new DateTime());
        $compteGestion->setMontant(0);

        return $compteGestion;
    }

    private function setTypeOperation(
        CompteGestionEntity $compteGestion,
        array $ios,
        string $libelle
    ) {
        /** @var $io ImportOperation */
        foreach ($ios as $io) {
            $i = $io->isCasseSensible() ? '' : 'i';
            if (preg_match('/' . $io->getLibelle() . '/' . $i, $libelle)) {
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
