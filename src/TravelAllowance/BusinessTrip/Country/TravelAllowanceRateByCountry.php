<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip\Country;

enum TravelAllowanceRateByCountry: int
{
    case PL = 10;
    case DE = 50;
    case GB = 75;

    public static function rate(string $country): int
    {
        $filterResult = array_values(
            array_filter(self::cases(), fn ($item) => $item->name === $country)
        );
        return $filterResult[0]?->value ?? 0;
    }

    public static function keys(): array
    {
        return array_map(fn ($item) => $item->name, self::cases());
    }
}
