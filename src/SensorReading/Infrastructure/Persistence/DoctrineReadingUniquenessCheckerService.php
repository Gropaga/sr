<?php

declare(strict_types=1);

namespace App\SensorReading\Infrastructure\Persistence;

use App\SensorReading\Domain\ReadingUniquenessCheckerService;
use App\SensorReading\Domain\SensorReadingId;
use App\SensorReading\Domain\SensorReadings;

final class DoctrineReadingUniquenessCheckerService implements ReadingUniquenessCheckerService
{
    private SensorReadings $sensorReadings;

    public function __construct(SensorReadings $sensorReadings)
    {
        $this->sensorReadings = $sensorReadings;
    }

    public function isUnique(SensorReadingId $id): bool
    {
        return null === $this->sensorReadings->get($id);
    }
}
