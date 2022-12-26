<?php

declare(strict_types=1);

namespace App\SensorReading\Application\Command;

final class AddApiReadingCommand
{
    private string $ipAddress;

    public function __construct(string $ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    public function ipAddress(): string
    {
        return $this->ipAddress;
    }
}
