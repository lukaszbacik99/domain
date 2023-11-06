<?php

declare(strict_types=1);

namespace App\TravelAllowance\BusinessTrip;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TravelAllowanceCalculatorTest extends TestCase
{
    private const EMPLOYEE_ID = 1;

    private TravelAllowanceCalculator $travelAllowanceCalculator;

    public function setUp(): void
    {
        $this->travelAllowanceCalculator = Factory::createCalculator();
    }

    /** @dataProvider calculateDataProvider */
    public function testCalculate(string $countryCode, string $startDate, string $endDate, int $expected): void
    {
        $result = $this->travelAllowanceCalculator->calculate(
            Values::create(
                employeeId: self::EMPLOYEE_ID,
                country: $countryCode,
                startDate: $this->createDate($startDate),
                endDate: $this->createDate($endDate),
            )
        );

        $this->assertEquals($expected, $result->travelAllowance);
    }

    public function calculateDataProvider(): array
    {
        // calendar used
        //  6  7  8  9 10 11 12 13 14 15 16 17
        // mo tu we th fr sa su mo tu we th fr

        return [
            [
                'countryCode' => 'PL',
                'startDate' => '2023-11-06 00:00',
                'endDate' => '2023-11-07 00:00',
                'expectedResult' => 10,
            ],
            [
                'countryCode' => 'DE',
                'startDate' => '2023-11-06 00:00',
                'endDate' => '2023-11-08 00:00',
                'expectedResult' => 2 * 50,
            ],
            [
                'countryCode' => 'GB',
                'startDate' => '2023-11-06 00:00',
                'endDate' => '2023-11-14 00:00',
                'expectedResult' => (5 * 75) + (1 * 75 * 2),
            ],
            [
                'countryCode' => 'PL',
                'startDate' => '2023-11-06 00:00',
                'endDate' => '2023-11-17 00:00',
                'expectedResult' => (5 * 10) + (4 * 10 * 2),
            ],
            [
                'countryCode' => 'PL',
                'startDate' => '2023-11-06 08:00',
                'endDate' => '2023-11-17 08:00',
                'expectedResult' => (5 * 10) + (5 * 10 * 2),
            ],
            [
                'countryCode' => 'PL',
                'startDate' => '2023-11-06 21:00',
                'endDate' => '2023-11-07 7:00',
                'expectedResult' => 0, // FIXME - should be 10 (?)
            ],
            [
                'countryCode' => 'PL',
                'startDate' => '2023-11-06 08:00',
                'endDate' => '2023-11-06 16:00',
                'expectedResult' => 10,
            ],
            [
                'countryCode' => 'PL',
                'startDate' => '2023-11-06 08:00',
                'endDate' => '2023-11-08 07:00',
                'expectedResult' => 20,
            ],
            [
                'countryCode' => 'PL',
                'startDate' => '2023-11-06 21:00',
                'endDate' => '2023-11-08 16:00',
                'expectedResult' => 20,
            ],
        ];
    }

    private function createDate(string $dateStr): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('Y-m-d H:i', $dateStr);
    }
}
