<?php

declare(strict_types=1);

namespace App\TravelAllowance;

use App\TravelAllowance\BusinessTrip\BusinessTripException;
use App\TravelAllowance\BusinessTrip\Factory;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class BusinessTripTest extends TestCase
{
    private const EMPLOYEE_ID = 1;

    private BusinessTrip $businessTrip;
    private BusinessTripRepositoryInterface $businessTripRepository;

    public function setUp(): void
    {
        $this->businessTripRepository = $this->createMock(BusinessTripRepositoryInterface::class);

        $this->businessTrip = Factory::create(
            $this->businessTripRepository,
        );
    }

    public function testOverlap(): void
    {
        $this->expectException(BusinessTripException::class);

        $this->businessTripRepository->expects($this->any())
            ->method('getBusinessTripCount')
            ->willReturn(1);

        $this->businessTrip->add(
            self::EMPLOYEE_ID,
            'PL',
            $this->createDate('2021-01-01 00:00'),
            $this->createDate('2021-01-02 00:00'),
        );
    }

    private function createDate(string $dateStr): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('Y-m-d H:i', $dateStr);
    }
}
