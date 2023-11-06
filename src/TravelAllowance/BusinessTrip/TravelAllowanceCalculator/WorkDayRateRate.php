<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator;

use DateTimeImmutable;

class WorkDayRateRate extends DayRateRateCalculations implements DayRateSpecification
{
    public function isSatisfiedBy(DateTimeImmutable $day): bool
    {
        return $this->isWorkDay($day);
    }

    public function calculateRate(int $baseRate): int
    {
        return $baseRate;
    }
}
