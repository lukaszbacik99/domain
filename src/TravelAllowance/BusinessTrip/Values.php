<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip;

use DateTimeImmutable;
use DateTimeInterface;
use Sushi\ValueObject;
use Sushi\ValueObject\Invariant;

class Values extends ValueObject
{
    public function __construct(
        public readonly int $employeeId,
        public readonly Country\Values $country,
        public readonly DateTimeImmutable $startDate,
        public readonly DateTimeImmutable $endDate,
        public readonly ?int $travelAllowance = null,
    ) {
        parent::__construct();
    }

    #[Invariant]
    public function startDateIsBeforeEndDate(): void
    {
        if ($this->startDate > $this->endDate) {
            throw BusinessTripException::invalidDates();
        }
    }

    #[Invariant]
    public function atLeastEightHours(): void
    {
        $diff = $this->endDate->diff($this->startDate);

        // Calculate the total number of seconds in the difference
        $totalSeconds = $diff->s + $diff->i * 60 + $diff->h * 3600 + $diff->days * 86400;

        // Calculate the total number of seconds in 8 hours
        $eightHoursInSeconds = 8 * 3600; // 8 hours * 3600 seconds/hour

        if ($totalSeconds < $eightHoursInSeconds) {
            throw BusinessTripException::atLeastEightHours();
        }
    }

    public static function create(
        int $employeeId,
        string $country,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate
    ): self {
        return new static(
            $employeeId,
            new Country\Values($country),
            DateTimeImmutable::createFromInterface($startDate),
            DateTimeImmutable::createFromInterface($endDate),
        );
    }
}
