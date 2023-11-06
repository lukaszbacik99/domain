<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator;

use DateTimeImmutable;

class IsFirstDayNotCountableRate extends DayRateRateCalculations implements DayRateSpecification
{
    private const MIDNIGHT_HOUR = 24;

    public function isSatisfiedBy(DateTimeImmutable $day): bool
    {
        if ($day == $this->startDate() && $this->isWorkDay($day)) {
            $endHour = $this->startDate() == $this->endDate()
                ? (int) self::$endDate->format('H')
                : self::MIDNIGHT_HOUR;

            $startHour = (int) self::$startDate->format('H');

            return ($endHour - $startHour) < self::MINIMUM_PER_DAY_HOURS;
        }

        return false;
    }

    public function calculateRate(int $baseRate): int
    {
        static::$firstDay = false;
        return 0;
    }
}
