<?php

namespace App\Util;

use App\Entity\CompteGestionEntity;
use App\Entity\DonneeBancaireEntity;
use App\Repository\ImportOperationRepository;
use DateTime;

class ImportManager
{
    const DEFAULT_DATE = '01/01/1970';
    const DEFAULT_LIBELLE = '--- indeterminé ---';

    /**
     * @var DateTime
     */
    private $defaultDate;

    public function __construct()
    {
        $this->defaultDate = new DateTime(self::DEFAULT_DATE);
    }

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
        $compteGestion = new CompteGestionEntity();
        $compteGestion->setDonneeBancaire($donneeBancaire);
        $compteGestion->setDate($this->defaultDate);
        $compteGestion->setLibelle(self::DEFAULT_LIBELLE);
        $compteGestion->setMontant(0);

        return $compteGestion;
    }

    private function isCompteOperationValide(CompteGestionEntity $compteGestion)
    {
        return ($compteGestion->getDate()->format('d/m/Y') != $this->defaultDate->format('d/m/Y'))
            && $compteGestion->getTypeOperation() != null
            && $compteGestion->getLibelle() != self::DEFAULT_LIBELLE;
    }

    private function setTypeOperation(CompteGestionEntity $compteGestion, array $ios, string $libelle)
    {
        /** @var $io ImportOperation */
        foreach ($ios as $io) {
            $i = $io->isCaseSensible ? "" : "i";
            if (preg_match("/" . $io->getLibelle() . "/" . $i, $libelle)) {
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