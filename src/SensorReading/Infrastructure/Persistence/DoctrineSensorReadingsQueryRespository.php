<?php

declare(strict_types=1);

namespace App\SensorReading\Infrastructure\Persistence;

use App\SensorReading\Domain\ReadModel\SensorReading as SensorReadingReadModel;
use App\SensorReading\Domain\ReadModel\SensorReadings;
use DateTimeImmutable;
use Decimal\Decimal;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineSensorReadingsQueryRespository implements SensorReadings
{
    private EntityManagerInterface $entityManger;

    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManger = $entityManger;
    }

    /**
     * @throws Exception
     */
    public function getMeanTemperatureForAllSensors(): array
    {
        $connection = $this->entityManger->getConnection();

        $sql = <<<SQL
SELECT id_sensor_id as sensor_id, avg(temperature_temperature) as temperature, date_trunc('day', timestamp) as timestamp
FROM sensor_reading
GROUP BY sensor_id, date_trunc('day', timestamp)
ORDER BY timestamp
SQL;

        $statement = $connection->prepare($sql);
        $query = $statement->executeQuery();

        $sensorReadings = [];
        foreach ($query->iterateAssociative() as $result) {
            $sensorReadings[] = $this->arrayResultToReadModel($result);
        }

        return $sensorReadings;
    }

    /**
     * @throws Exception
     */
    public function getMeanTemperature(string $sensorId): array
    {
        $connection = $this->entityManger->getConnection();

        $sql = <<<SQL
SELECT id_sensor_id as sensor_id, avg(temperature_temperature) as temperature, date_trunc('hour', timestamp) as timestamp
FROM sensor_reading
WHERE id_sensor_id = ?
GROUP BY sensor_id, date_trunc('hour', timestamp)
ORDER BY timestamp
SQL;

        $statement = $connection->prepare($sql);
        $statement->bindValue(1, $sensorId);
        $query = $statement->executeQuery();

        $sensorReadings = [];
        foreach ($query->iterateAssociative() as $result) {
            $sensorReadings[] = $this->arrayResultToReadModel($result);
        }

        return $sensorReadings;
    }

    private function arrayResultToReadModel(array $result): SensorReadingReadModel
    {
        return new SensorReadingReadModel(
            new Decimal($result['temperature']),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result['timestamp']),
            $result['sensor_id']
        );
    }
}
