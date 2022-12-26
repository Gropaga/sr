<?php

declare(strict_types=1);

namespace App\SensorReading\Domain;

final class SensorReadingId
{
    public function __construct(
        private string $readingId,
        private string $sensorId
    ) {}

    public function readingId(): string
    {
        return $this->readingId;
    }

    public function sensorId(): string
    {
        return $this->sensorId;
    }
}
