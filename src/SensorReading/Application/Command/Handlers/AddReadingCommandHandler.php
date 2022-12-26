<?php

declare(strict_types=1);

namespace App\SensorReading\Application\Command\Handlers;

use App\SensorReading\Application\Command\AddReadingCommand;
use App\SensorReading\Domain\ReadingUniquenessCheckerService;
use App\SensorReading\Domain\SensorReading;
use App\SensorReading\Domain\SensorReadingId;
use App\SensorReading\Domain\SensorReadings;
use App\SensorReading\Domain\Temperature;
use Monolog\DateTimeImmutable;
use Ramsey\Uuid\Uuid;

final class AddReadingCommandHandler
{
    private SensorReadings $sensorReadings;
    private ReadingUniquenessCheckerService $readingUniquenessChecker;

    public function __construct(
        SensorReadings $sensorReadings,
        ReadingUniquenessCheckerService $readingUniquenessChecker
    ) {
        $this->sensorReadings = $sensorReadings;
        $this->readingUniquenessChecker = $readingUniquenessChecker;
    }

    public function __invoke(AddReadingCommand $command): void
    {
        $sensorReadingDto = $command->sensorReadingDto();

        $sensorId = $sensorReadingDto->sensorId;
        $temperature = $sensorReadingDto->temperature;

        $sensorReading = SensorReading::create(
            new SensorReadingId(
                Uuid::uuid4()->toString(),
                $sensorId
            ),
            Temperature::fromCelsius($temperature),
            new DateTimeImmutable(false),
            $this->readingUniquenessChecker
        );

        $this->sensorReadings->save($sensorReading);
    }
}
