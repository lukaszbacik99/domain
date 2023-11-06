<?php

declare(strict_types=1);

namespace App\TravelAllowance;

use App\TravelAllowance\BusinessTrip\Values;
use DateTimeImmutable;

interface BusinessTripRepositoryInterface
{
    public function add(Values $values): void;

    /*
     * Return the number of already saved business trips for a given employee id in a given time range.
     *
     * Time range "start date" is $endDateIsGreaterOrEqual,
     * and its "end date" should be passed as $startDateIsLowerOrEqual
     */
    public function getBusinessTripCount(
        int $employeeId,
        DateTimeImmutable $endDateIsGreaterOrEqual,
        DateTimeImmutable $startDateIsLowerOrEqual,
    ): int;
}
