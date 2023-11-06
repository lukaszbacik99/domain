<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator;

use DateTimeImmutable;

abstract class DayRateRateCalculations
{
    protected const MINIMUM_PER_DAY_HOURS = 8;
    private const SATURDAY = 6;

    protected static bool $firstDay = true;
    protected static DateTimeImmutable $startDate;
    protected static DateTimeImmutable $endDate;

    public static function setDates(DateTimeImmutable $startDate, DateTimeImmutable $endDate): void
    {
        self::$startDate = $startDate;
        self::$endDate = $endDate;
    }

    protected function isWorkDay($day): bool
    {
        return $day->format('N') < self::SATURDAY;
    }

    protected function startDate(): DateTimeImmutable
    {
        return self::$startDate->setTime(0, 0, 0);
    }

    protected function endDate(): DateTimeImmutable
    {
        return self::$endDate->setTime(0, 0, 0);
    }
}
