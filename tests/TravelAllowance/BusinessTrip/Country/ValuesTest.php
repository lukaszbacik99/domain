<?php

declare(strict_types=1);

namespace Tests\TravelAllowance\BusinessTrip\Country;

use App\TravelAllowance\BusinessTrip\Country\CountryException;
use App\TravelAllowance\BusinessTrip\Country\Values;
use PHPUnit\Framework\TestCase;

class ValuesTest extends TestCase
{
    /** @dataProvider createDataProvider */
    public function testCreate(string $code, bool $valid): void
    {
        if ($valid === false) {
            $this->expectException(CountryException::class);
        }

        $this->assertInstanceOf(Values::class, new Values($code));
    }

    public function createDataProvider()
    {
        return [
            [
                'PL', true
            ],
            [
                'DE', true
            ],
            [
                'GB', true
            ],
            [
                'FR', false
            ],
            [
                'X', false
            ],
        ];
    }
}
