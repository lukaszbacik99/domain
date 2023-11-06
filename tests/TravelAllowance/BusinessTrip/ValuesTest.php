<?php

declare(strict_types=1);

namespace Tests\TravelAllowance\BusinessTrip;

use App\TravelAllowance\BusinessTrip\BusinessTripException;
use App\TravelAllowance\BusinessTrip\Values;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ValuesTest extends TestCase
{
    private const EMPLOYEE_ID = 1;
    private const COUNTRY_CODE = 'PL';

    /** @dataProvider createDataProvider */
    public function testCreate(string $startDate, string $endDate, bool $valid): void
    {
        if ($valid === false) {
            $this->expectException(BusinessTripException::class);
        }

        $this->assertInstanceOf(
            Values::class,
            Values::create(
                self::EMPLOYEE_ID,
                self::COUNTRY_CODE,
                $this->createDate($startDate),
                $this->createDate($endDate),
            )
        );
    }

    public function createDataProvider(): array
    {
        return [
            ['2020-01-01 00:00', '2020-01-02 00:00', true],
            ['2020-01-01 00:00', '2020-01-01 07:00', false],
            ['2020-01-01 20:00', '2020-01-02 12:00', true],
            ['2020-01-01 20:00', '2020-01-02 01:00', false],
            ['2020-01-01 16:45', '2020-01-02 01:15', true],
            ['2020-01-01 16:45', '2020-01-02 00:15', false],
            ['2020-01-02 00:00', '2020-01-01 00:00', false],
            ['2020-01-01 00:00', '2021-01-01 07:00', true],
        ];
    }

    private function createDate(string $dateStr): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('Y-m-d H:i', $dateStr);
    }
}
