<?php

declare(strict_types=1);

namespace App\SensorReading\Application\Query;

use App\SensorReading\Application\Query\Dto\SensorReadingsDto;
use App\SensorReading\Application\Query\Dto\SensorReadingsDtoFactory;
use App\SensorReading\Domain\ReadModel\SensorReadings;

final class GetMeanTemperatureForAllSensorsService
{
    private SensorReadings $sensorReadings;
    private SensorReadingsDtoFactory $sensorReadingsDtoFactory;

    public function __construct(
        SensorReadings $sensorReadings,
        SensorReadingsDtoFactory $sensorReadingsDtoFactory
    )
    {
        $this->sensorReadings = $sensorReadings;
        $this->sensorReadingsDtoFactory = $sensorReadingsDtoFactory;
    }

    public function exec(): SensorReadingsDto
    {
        return $this->sensorReadingsDtoFactory->fromSensorReadingsReadModel(
            ...$this->sensorReadings->getMeanTemperatureForAllSensors()
        );
    }
}
