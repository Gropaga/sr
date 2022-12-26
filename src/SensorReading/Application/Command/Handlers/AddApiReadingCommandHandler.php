<?php

declare(strict_types=1);

namespace App\SensorReading\Application\Command\Handlers;

use App\SensorReading\Application\Command\AddApiReadingCommand;
use App\SensorReading\Domain\ReadingUniquenessCheckerService;
use App\SensorReading\Domain\SensorReading;
use App\SensorReading\Domain\SensorReadingId;
use App\SensorReading\Domain\SensorReadings;
use App\SensorReading\Domain\SensorReadingsApiClient;
use App\SensorReading\Domain\Temperature;
use DateTimeImmutable;
use Decimal\Decimal;

final class AddApiReadingCommandHandler
{
    private SensorReadingsApiClient $client;
    private SensorReadings $sensorReadings;
    private ReadingUniquenessCheckerService $readingUniquenessChecker;

    public function __construct(
        SensorReadingsApiClient $client,
        SensorReadings $sensorReadings,
        ReadingUniquenessCheckerService $readingUniquenessChecker
    ) {
        $this->client = $client;
        $this->sensorReadings = $sensorReadings;
        $this->readingUniquenessChecker = $readingUniquenessChecker;
    }

    public function __invoke(AddApiReadingCommand $command)
    {
        $ipAddress = $command->ipAddress();

        $sensorReadingDto = $this->client->getSensorReadings($ipAddress);

        $readingId = $sensorReadingDto->readingId;
        $temperature = new Decimal($sensorReadingDto->temperature);

        $sensorReading = SensorReading::create(
            new SensorReadingId(
                $readingId,
                $ipAddress
            ),
            Temperature::fromFahrenheit($temperature),
            new DateTimeImmutable(),
            $this->readingUniquenessChecker
        );

        $this->sensorReadings->save($sensorReading);
    }
}
