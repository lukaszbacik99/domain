<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator;

use DateTimeImmutable;

class AboveSeventhDayRate extends DayRateRateCalculations implements DayRateSpecification
{
    public function isSatisfiedBy(DateTimeImmutable $day): bool
    {
        $interval = static::$startDate->diff($day);
        $days = $interval->days;

        static::$firstDay === false ?: $days++;

        return $days >= 7;
    }

    public function calculateRate(int $baseRate): int
    {
        return $baseRate * 2;
    }
}
