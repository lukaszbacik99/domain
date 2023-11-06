<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip;

use InvalidArgumentException;

class BusinessTripException extends InvalidArgumentException
{
    public static function oneTripAtATime(): self
    {
        return new self('Only one trip at a time is allowed');
    }

    public static function invalidDates(): self
    {
        return new self('Start date cannot be greater than end date');
    }

    public static function atLeastEightHours(): self
    {
        return new self('Trip must be at least 8 hours long');
    }
}
