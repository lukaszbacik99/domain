<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator;

use DateTimeImmutable;

class IsLastDayNotCountableRate extends DayRateRateCalculations implements DayRateSpecification
{
    public function isSatisfiedBy(DateTimeImmutable $day): bool
    {
        if ($day == $this->endDate() && $this->isWorkDay($day)) {
            if ($this->startDate() == $this->endDate()) {
                return false;
            }

            $endHour = (int) self::$endDate->format('H');
            return $endHour < self::MINIMUM_PER_DAY_HOURS;
        }

        return false;
    }

    public function calculateRate(int $baseRate): int
    {
        return 0;
    }
}
