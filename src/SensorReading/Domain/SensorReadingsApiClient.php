<?php

namespace App\SensorReading\Domain;

use App\SensorReading\Application\Command\Dto\SensorReadingDto;

interface SensorReadingsApiClient
{
    public function getSensorReadings(string $ipAddress): SensorReadingDto;
}
