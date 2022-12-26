<?php

declare(strict_types=1);

namespace App\SensorReading\Domain;

interface ReadingUniquenessCheckerService
{
    public function isUnique(SensorReadingId $id): bool;
}
