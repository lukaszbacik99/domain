<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator;

use DateTimeImmutable;

interface DayRateSpecification
{
    public function isSatisfiedBy(DateTimeImmutable $day): bool;
    public function calculateRate(int $baseRate): int;
}
