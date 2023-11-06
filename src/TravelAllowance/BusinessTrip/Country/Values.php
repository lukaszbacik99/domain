<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip\Country;

use Sushi\ValueObject;
use Sushi\ValueObject\Invariant;

class Values extends ValueObject
{
    public function __construct(
        public readonly string $code
    ) {
        parent::__construct();
    }

    #[Invariant]
    public function codeIsAllowed(): void
    {
        if (!in_array($this->code, TravelAllowanceRateByCountry::keys())) {
            throw CountryException::invalidCode($this->code);
        }
    }
}
