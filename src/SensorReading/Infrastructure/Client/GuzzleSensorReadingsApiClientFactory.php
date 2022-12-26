<?php

declare(strict_types=1);

namespace App\SensorReading\Infrastructure\Client;

use App\SensorReading\Domain\SensorReadingsApiClient;
use GuzzleHttp\Client;

final class GuzzleSensorReadingsApiClientFactory
{
    public function create(SensorReadingsDtoFactory $dtoFactory): SensorReadingsApiClient
    {
        return new GuzzleSensorReadingsApiClient(
            new Client(),
            $dtoFactory
        );
    }
}
