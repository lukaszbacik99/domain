<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip\Country;

use InvalidArgumentException;

class CountryException extends InvalidArgumentException
{
    public static function invalidCode(string $code): self
    {
        return new self("Invalid country code: {$code}");
    }
}
