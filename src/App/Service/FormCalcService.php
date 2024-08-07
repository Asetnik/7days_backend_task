<?php

namespace App\Service;

use DateTime;
use DateTimeZone;

class FormCalcService
{

    /**
     * @param array $formData
     * @return array
     * @throws \Exception
     */
    public function calcResult(array $formData): array
    {
        $date = new DateTime($formData['date'], new DateTimeZone($formData['timezone']));
        $utcDate = new DateTime($formData['date'], new DateTimeZone('UTC'));
        $febDate = new DateTime($date->format('Y') . '-02-01');

        return [
            'timezone' => $formData['timezone'],
            'minutes_offset' => $this->getMinutesOffset($utcDate, $date),
            'february_days' => $febDate->format('t'),
            'month_name' => $date->format('F'),
            'month_days' => $date->format('t'),
        ];
    }

    /**
     * @param DateTime $a
     * @param DateTime $b
     * @return int
     */
    public static function getMinutesOffset(\DateTime $a, \DateTime $b): int
    {
        return ($a->getTimestamp() - $b->getTimestamp()) / 60;
    }
}