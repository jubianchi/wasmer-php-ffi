<?php declare(strict_types=1);

namespace Wasmer\Types;

/**
 * @method static self CONST()
 * @method static self VAR()
 */
final class Mutability extends Enum
{
    private const CONST = 0;
    private const VAR = 1;

    /**
     * @psalm-var array<string, int>
     */
    private static array $values = [
        'CONST' => self::CONST,
        'VAR' => self::VAR,
    ];

    /**
     * @psalm-return array<string, int>
     */
    protected static function values(): array
    {
        return self::$values;
    }
}