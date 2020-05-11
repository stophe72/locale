<?php

namespace App\Util;

use DateTime;
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

    public static function verifyDate(string $date, string $format = 'd/m/Y', bool $strict = true)
    {
        $dateTime = DateTime::createFromFormat($format, $date);
        if ($strict) {
            $errors = DateTime::getLastErrors();
            if (!empty($errors['warning_count'])) {
                return false;
            }
        }
        return $dateTime !== false;
    }
}
