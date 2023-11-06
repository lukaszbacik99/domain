<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip;

use App\TravelAllowance\BusinessTrip\Country\TravelAllowanceRateByCountry;
use App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator\DayRateSpecification;
use App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator\DayRateRateCalculations;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;

class TravelAllowanceCalculator
{
    private array $specifications;

    public function __construct(DayRateSpecification ...$specifications,)
    {
        $this->specifications = $specifications;
    }

    public function calculate(Values $businessTrip): Values
    {
        $result = 0;

        $startDateMidnight = $businessTrip->startDate->setTime(0, 0, 0);
        $interval = new DateInterval('P1D'); // 1 day interval
        $dateRange = new DatePeriod($startDateMidnight, $interval, $businessTrip->endDate);

        DayRateRateCalculations::setDates($businessTrip->startDate, $businessTrip->endDate);

        foreach ($dateRange as $date) {
            $result += $this->calculateDayRate($businessTrip, $date);
        }

        return $businessTrip->set(travelAllowance: $result);
    }

    private function calculateDayRate(Values $businessTrip, DateTimeImmutable $day): int
    {
        $baseRate = TravelAllowanceRateByCountry::rate($businessTrip->country->code);

        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($day)) {
                return $specification->calculateRate($baseRate);
            }
        }

        return 0;
    }
}
