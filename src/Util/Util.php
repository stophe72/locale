<?php

namespace App\Util;

use DateTimeInterface;

class Util
{
    public static function orderDates(DateTimeInterface $date1, DateTimeInterface $date2)
    {
        if ($date1->getTimestamp() > $date2->getTimestamp()) {
            $d = $date2;
            $date1 = $date2;
            $date2 = $d;
        }
        return [
            $date1,
            $date2,
        ];
    }
}
