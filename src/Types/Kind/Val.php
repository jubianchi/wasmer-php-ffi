<?php declare(strict_types=1);

namespace Wasmer\Types\Kind;

use Wasmer\Types\Enum;

/**
 * @method static self I32()
 * @method static self I64()
 * @method static self F32()
 * @method static self F64()
 * @method static self AnyRef()
 * @method static self FuncRef()
 */
final class Val extends Enum
{
    private const I32 = 0;
    private const I64 = 1;
    private const F32 = 2;
    private const F64 = 3;
    private const AnyRef = 128;
    private const FuncRef = 129;

    /**
     * @psalm-var array<string, int>
     */
    private static array $values = [
        'I32' => self::I32,
        'I64' => self::I64,
        'F32' => self::F32,
        'F64' => self::F64,
        'AnyRef' => self::AnyRef,
        'FuncRef' => self::FuncRef,
    ];

    /**
     * @psalm-return array<string, int>
     */
    protected static function values(): array
    {
        return self::$values;
    }
}