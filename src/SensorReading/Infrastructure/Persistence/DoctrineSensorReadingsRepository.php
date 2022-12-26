<?php

declare(strict_types=1);

namespace App\SensorReading\Infrastructure\Persistence;

use App\SensorReading\Domain\SensorReading;
use App\SensorReading\Domain\SensorReadingId;
use App\SensorReading\Domain\SensorReadings;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

final class DoctrineSensorReadingsRepository implements SensorReadings
{
    private EntityManagerInterface $entityManger;

    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManger = $entityManger;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function get(SensorReadingId $sensorReadingId): ?SensorReading
    {
        $queryBuilder = $this->entityManger->createQueryBuilder();
        $queryBuilder
            ->select('s')
            ->from(SensorReading::class, 's')
            ->where('s.id.sensorId = :sensor_id')
            ->andWhere('s.id.readingId = :reading_id')
            ->setParameter(':sensor_id', $sensorReadingId->sensorId())
            ->setParameter(':reading_id', $sensorReadingId->readingId())
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function save(SensorReading $sensorReading): void
    {
        $this->entityManger->persist($sensorReading);
        $this->entityManger->flush();
    }
}
