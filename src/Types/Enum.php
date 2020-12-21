<?php declare(strict_types=1);

namespace Wasmer\Types;

use Wasmer\Exceptions\Runtime;

abstract class Enum
{
    /**
     * @psalm-var array<class-string<self>, array<string, static>>
     */
    private static array $cache = [];

    /**
     * @psalm-var array<class-string<self>, array<int, static>>
     */
    private static array $reverse = [];

    /**
     * @psalm-immutable
     */
    private int $value;

    private final function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @psalm-return array{name: string, value: int}
     */
    public function __debugInfo(): array
    {
        return ['name' => $this->name(), 'value' => $this->value];
    }

    public function __toString(): string
    {
        return $this->name();
    }

    public function name(): string
    {
        return array_search($this->value, static::values()) ?: throw new Runtime(sprintf('Invalid value "%s" for "%s"', $this->value, static::class));
    }

    public function value(): int
    {
        return $this->value;
    }

    public static function __callStatic(string $name, array $_): static
    {
        if (!isset(self::$cache[static::class][$name])) {
            self::$cache[static::class][$name] = new static(static::values()[$name]);
            self::$reverse[static::class][self::$cache[static::class][$name]->value] = self::$cache[static::class][$name];
        }

        return self::$cache[static::class][$name];
    }

    public static function new(int $value): static
    {
        if (!isset(self::$reverse[static::class][$value])) {
            $name = array_search($value, static::values(), true) ?: throw new Runtime(sprintf('Invalid value "%s" for "%s"', $value, static::class));
            self::$cache[static::class][$name] = new static(static::values()[$name]);
            self::$reverse[static::class][self::$cache[static::class][$name]->value] = self::$cache[static::class][$name];
        }

        return self::$reverse[static::class][$value];
    }

    /**
     * @psalm-return array<string, int>
     */
    abstract protected static function values(): array;
}