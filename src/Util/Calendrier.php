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
        $calendrier = [];
        for ($i = 1; $i <= 12; $i++) {
            $mois = [];
            $premierJour = date('N',  mktime(0, 0, 0, $i, 1, $this->annee));
            $nbJours = cal_days_in_month(CAL_GREGORIAN, $i, $this->annee);
            $j = 1;
            while ($j < $premierJour) {
                $mois[] = new Jour();
                $j++;
            }
            $j = 1;
            while ($j <= $nbJours) {
                $date->setDate($this->annee, $i, $j);
                $mois[] = new Jour($j, in_array($date->format('Y-m-d'), $this->visites));
                $j++;
            }
            $j = count($mois);
            while ($j % 7 != 0) {
                $mois[] = new Jour();
                $j++;
            }
            $calendrier[$this->getMoisName($i)] = $mois;
        }
        return $calendrier;
    }

    private function getMoisName(int $mois)
    {
        switch ($mois) {
            case 1:
                return  'Janvier';
            case 2:
                return  'Février';
            case 3:
                return  'Mars';
            case 4:
                return  'Avril';
            case 5:
                return  'Mai';
            case 6:
                return  'Juin';
            case 7:
                return  'Juillet';
            case 8:
                return  'Août';
            case 9:
                return  'Septembre';
            case 10:
                return  'Octobre';
            case 11:
                return  'Novembre';
            default:
                return  'Décembre';
        }
    }

    /**
     * Get the value of annee
     */
    public function getAnnee()
    {
        return $this->annee;
    }
}
