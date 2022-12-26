<?php

declare(strict_types=1);

namespace App\SensorReading\Infrastructure\Client;

use App\SensorReading\Application\Command\Dto\SensorReadingDto;
use App\SensorReading\Domain\SensorReadingsApiClient;
use GuzzleHttp\ClientInterface;
use RuntimeException;

final class GuzzleSensorReadingsApiClient implements SensorReadingsApiClient
{
    private const PATH = '/data';

    private ClientInterface $guzzle;
    private SensorReadingsDtoFactory $dtoFactory;

    public function __construct(
        ClientInterface $guzzle,
        SensorReadingsDtoFactory $dtoFactory
    ) {
        $this->guzzle = $guzzle;
        $this->dtoFactory = $dtoFactory;
    }

    public function getSensorReadings(string $ipAddress): SensorReadingDto
    {
        $response = $this->guzzle->get($ipAddress . self::PATH);

        if (null === $response) {
            throw new RuntimeException('No response received');
        }

        $body = $response->getBody();
        if (null === $body) {
            throw new RuntimeException('No body available');
        }

        return $this->dtoFactory->fromCsv((string) $body);
    }
}
