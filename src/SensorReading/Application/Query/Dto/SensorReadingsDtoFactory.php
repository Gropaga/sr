<?php

declare(strict_types=1);

namespace App\SensorReading\Application\Query\Dto;

use App\SensorReading\Domain\ReadModel\SensorReading;

final class SensorReadingsDtoFactory
{
    public function fromSensorReadingsReadModel(SensorReading ...$sensorReadings): SensorReadingsDto
    {
        $sensorReadingsDto = new SensorReadingsDto();
        $sensorReadingsDto->sensorReadings = [];
        foreach ($sensorReadings as $sensorReading) {
            $sensorReadingDto = new SensorReadingDto();
            $sensorReadingDto->timestamp = $sensorReading->timestamp();
            $sensorReadingDto->temperature = $sensorReading->temperature();

            if ($sensorReading->hasSensorId()) {
                $sensorReadingDto->sensorId = $sensorReading->sensorId();
            }

            $sensorReadingsDto->sensorReadings[] = $sensorReadingDto;
        }

        return $sensorReadingsDto;
    }
}
