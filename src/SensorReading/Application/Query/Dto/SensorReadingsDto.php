<?php

declare(strict_types=1);

namespace App\SensorReading\Application\Query\Dto;

use JsonException;

final class SensorReadingsDto
{
    /** @var $sensorReadings SensorReadingDto[] */
    public array $sensorReadings;

    public function toArray(): array {
        return array_map(static function(SensorReadingDto $sensorReadingDto) {
            return $sensorReadingDto->toArray();
        }, $this->sensorReadings);
    }

    /**
     * @throws JsonException
     */
    public function __toString(): string {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}
