<?php

namespace App\Util;

use App\Models\Jour;
use DateTime;

class Calendrier
{
    private $annee;
    private $visites = [];

    public function __construct(array $visites, $annee = null)
    {
        if (is_null($annee)) {
            $this->annee = date('Y');
        } else {
            $this->annee = $annee;
        }
        foreach ($visites as $visite) {
            $this->visites[] = $visite->getDate()->format('Y-m-d');
        }
    }

    public function generate()
    {
        $date = new DateTime();
        $mois = [];
        for ($i = 1; $i <= 12; $i++) {
            $jours = [];
            $premierJour = date('N',  mktime(0, 0, 0, $i, 1, $this->annee));
            $nbJours = cal_days_in_month(CAL_GREGORIAN, $i, $this->annee);
            $j = 1;
            while ($j < $premierJour) {
                $jours[] = new Jour();
                $j++;
            }
            $j = 1;
            while ($j <= $nbJours) {
                $date->setDate($this->annee, $i, $j);
                $jours[] = new Jour($j, in_array($date->format('Y-m-d'), $this->visites));
                $j++;
            }
            $j = count($jours);
            while ($j % 7 != 0) {
                $jours[] = new Jour();
                $j++;
            }
            $mois[$i] = $jours;
        }
        return $mois;
    }

    /**
     * Get the value of annee
     */
    public function getAnnee()
    {
        return $this->annee;
    }
}
