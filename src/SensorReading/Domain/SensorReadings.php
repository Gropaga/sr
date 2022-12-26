<?php

namespace App\SensorReading\Domain;

interface SensorReadings
{
    public function get(SensorReadingId $sensorReadingId): ?SensorReading;
    public function save(SensorReading $sensorReading): void;
}
