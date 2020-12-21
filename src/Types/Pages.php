<?php declare(strict_types = 1);

namespace Wasmer\Types;

final class Pages
{
    public const SIZE = 0x10000;

    private int $size;

    private function __construct(int $size)
    {
        $this->size = $size;
    }

    public function __debugInfo(): array
    {
        return ['size' => $this->size()];
    }

    public function size(): int
    {
        return $this->size;
    }

    public static function new(int $size): self
    {
        return new self($size);
    }
}