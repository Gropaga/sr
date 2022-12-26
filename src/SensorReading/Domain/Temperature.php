<?php

declare(strict_types=1);

namespace App\SensorReading\Domain;

use Decimal\Decimal;

final class Temperature
{
    private Decimal $temperature;

    private function __construct(Decimal $temperature)
    {
        $this->temperature = $temperature;
    }

    public function temperature(): Decimal
    {
        return $this->temperature;
    }

    public static function fromCelsius(Decimal $temperature): self
    {
        return new self($temperature);
    }

    public static function fromFahrenheit(Decimal $temperature): self
    {
        return new self(self::convertFahrenheitToCelsius($temperature));
    }

    private static function convertFahrenheitToCelsius(Decimal $temperature): Decimal
    {
        return $temperature->sub('32')->div( '1.8');
    }
}
