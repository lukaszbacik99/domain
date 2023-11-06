<?php

declare(strict_types=1);

namespace App\TravelAllowance;

use App\TravelAllowance\BusinessTrip\Values;
use DateTimeImmutable;

interface BusinessTripRepositoryInterface
{
    public function add(Values $values): void;
    public function getBusinessTripCount(
        int $employeeId,
        ?DateTimeImmutable $endDateIsGreaterOrEqual,
        ?DateTimeImmutable $startDateIsLowerOrEqual,
    ): int;
}
