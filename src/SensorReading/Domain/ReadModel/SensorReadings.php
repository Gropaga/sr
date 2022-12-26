<?php

namespace App\SensorReading\Domain\ReadModel;

interface SensorReadings
{
    public function getMeanTemperatureForAllSensors(): array;
    public function getMeanTemperature(string $sensorId): array;
}
