<?php

declare(strict_types=1);

namespace App\SensorReading\Infrastructure\Persistence\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Decimal\Decimal;

final class DecimalType extends Type
{
    private const TYPE = 'decimal_decimal';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getDecimalTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Decimal($value);
    }

    public function getName()
    {
        return self::TYPE;
    }
}
