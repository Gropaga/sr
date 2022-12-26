<?php

declare(strict_types=1);

namespace App\SensorReading\Domain;

use DateTimeImmutable;
use DomainException;

final class SensorReading
{
    private SensorReadingId $id;
    private Temperature $temperature;
    private DateTimeImmutable $timestamp;

    private function __construct(
        SensorReadingId $id,
        Temperature $temperature,
        DateTimeImmutable $timestamp
    ) {
        $this->id = $id;
        $this->temperature = $temperature;
        $this->timestamp = $timestamp;
    }

    static function create(
        SensorReadingId $id,
        Temperature $temperature,
        DateTimeImmutable $timestamp,
        ReadingUniquenessCheckerService $readingUniquenessChecker
    ): self {
        if (false === $readingUniquenessChecker->isUnique($id)) {
            throw new DomainException(
                sprintf(
                    'Reading id %s for sensor id %s is already saved.',
                    $id->readingId(),
                    $id->sensorId()
                )
            );
        }

        return new self($id, $temperature, $timestamp);
    }

    public function id(): SensorReadingId
    {
        return $this->id;
    }

    public function temperature(): Temperature
    {
        return $this->temperature;
    }

    public function timestamp(): DateTimeImmutable
    {
        return $this->timestamp;
    }
}
