<?php

declare(strict_types=1);

namespace App\SensorReading\Domain\ReadModel;

use Decimal\Decimal;
use DateTimeImmutable;

final class SensorReading
{
    private Decimal $temperature;
    private DateTimeImmutable $timestamp;
    private ?string $sensorId;

    public function __construct(
        Decimal $temperature,
        DateTimeImmutable $timestamp,
        ?string $sensorId
    )
    {
        $this->temperature = $temperature;
        $this->timestamp = $timestamp;
        $this->sensorId = $sensorId;
    }

    public function temperature(): Decimal
    {
        return $this->temperature;
    }

    public function timestamp(): DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function hasSensorId(): bool
    {
        return null !== $this->sensorId;
    }

    public function sensorId(): string
    {
        return $this->sensorId;
    }
}
