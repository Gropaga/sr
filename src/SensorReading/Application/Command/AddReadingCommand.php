<?php

declare(strict_types=1);

namespace App\SensorReading\Application\Command;

use App\SensorReading\Application\Command\Dto\SensorReadingDto;

final class AddReadingCommand
{
    private SensorReadingDto $sensorReadingDto;

    public function __construct(SensorReadingDto $sensorReadingDto)
    {
        $this->sensorReadingDto = $sensorReadingDto;
    }

    public function sensorReadingDto(): SensorReadingDto
    {
        return $this->sensorReadingDto;
    }
}
