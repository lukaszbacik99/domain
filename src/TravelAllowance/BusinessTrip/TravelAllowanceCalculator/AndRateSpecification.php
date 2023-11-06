<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator;

use DateTimeImmutable;

class AndRateSpecification implements DayRateSpecification
{
    private array $specifications;

    public function __construct(DayRateSpecification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(DateTimeImmutable $day): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($day)) {
                return false;
            }
        }

        return true;
    }

    public function calculateRate(int $baseRate): int
    {
        $result = null;
        foreach ($this->specifications as $specification) {
            $result = $specification->calculateRate($result ?? $baseRate);
        }

        return $result ?? 0;
    }
}
