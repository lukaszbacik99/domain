<?php

declare(strict_types=1);

namespace App\TravelAllowance;

use App\TravelAllowance\BusinessTrip\BusinessTripException;
use App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator;
use App\TravelAllowance\BusinessTrip\Values as BusinessTripValues;
use DateTimeInterface;

class BusinessTrip
{
    public function __construct(
        private readonly BusinessTripRepositoryInterface $businessTripRepository,
        private readonly TravelAllowanceCalculator $travelAllowance,
    ) {
    }

    public function add(
        int $employeeId,
        string $country,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate
    ): void {
        $values = BusinessTripValues::create($employeeId, $country, $startDate, $endDate);
        if ($this->isNewTripOverlap($values)) {
            throw BusinessTripException::oneTripAtATime();
        }
        $valuesWithTravelAllowanceCalculated = $this->travelAllowance->calculate($values);
        $this->businessTripRepository->add($valuesWithTravelAllowanceCalculated);
    }

    private function isNewTripOverlap(BusinessTripValues $values): bool
    {
        $businessTripCount = $this->businessTripRepository->getBusinessTripCount(
            $values->employeeId,
            endDateIsGreaterOrEqual: $values->startDate,
            startDateIsLowerOrEqual: $values->endDate
        );

        return $businessTripCount > 0;
    }
}
