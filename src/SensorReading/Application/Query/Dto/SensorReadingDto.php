<?php

declare(strict_types=1);

namespace App\SensorReading\Application\Query\Dto;

use DateTimeImmutable;
use Decimal\Decimal;

final class SensorReadingDto
{
    public Decimal $temperature;
    public DateTimeImmutable $timestamp;
    public ?string $sensorId = null;

    public function toArray(): array
    {
        $array = [
            'temperature' => $this->temperature->toString(),
            'timestamp' => $this->timestamp->format('Y-m-d H:i:s'),
        ];

        if (null !== $this->sensorId) {
            $array['sensorId'] = $this->sensorId;
        }

        return $array;
    }
}
