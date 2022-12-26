<?php

declare(strict_types=1);

namespace App\SensorReading\Application\Command\Dto;

use Decimal\Decimal;

final class SensorReadingDto
{
    public string $sensorId;
    public string $readingId;
    public Decimal $temperature;
}
