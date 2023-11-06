<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip;

use App\TravelAllowance\BusinessTrip;
use App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator\AboveSeventhDayRate;
use App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator\AndRateSpecification;
use App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator\IsFirstDayNotCountableRate;
use App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator\IsLastDayNotCountableRate;
use App\TravelAllowance\BusinessTrip\TravelAllowanceCalculator\WorkDayRateRate;
use App\TravelAllowance\BusinessTripRepositoryInterface;

class Factory
{
    public static function create(
        BusinessTripRepositoryInterface $businessTripRepository,
    ): BusinessTrip {
        return new BusinessTrip($businessTripRepository, self::createCalculator());
    }

    public static function createCalculator(): TravelAllowanceCalculator
    {
        return new TravelAllowanceCalculator(
            new IsFirstDayNotCountableRate(),
            new IsLastDayNotCountableRate(),
            new AndRateSpecification(new WorkDayRateRate(), new AboveSeventhDayRate()),
            new WorkDayRateRate(),
        );
    }
}
