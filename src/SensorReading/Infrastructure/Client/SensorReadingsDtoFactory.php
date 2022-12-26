<?php

declare(strict_types=1);

namespace App\SensorReading\Infrastructure\Client;

use App\SensorReading\Application\Command\Dto\SensorReadingDto;
use Decimal\Decimal;

final class SensorReadingsDtoFactory
{
    public function fromCsv(string $csvReadings): SensorReadingDto
    {
        [$readingId, $temperature] = str_getcsv($csvReadings);

        $sensorReadingDto = new SensorReadingDto();
        $sensorReadingDto->readingId = $readingId;
        $sensorReadingDto->temperature = new Decimal($temperature);

        return $sensorReadingDto;
    }
}
