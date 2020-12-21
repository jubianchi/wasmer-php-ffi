<?php declare(strict_types=1);

namespace Wasmer;

use Wasmer\Types\Vec\Byte;

final class Wat extends Entity
{
    private Byte $bytes;

    public function __construct(string $wat)
    {
        $this->bytes = new Types\Vec\Byte($wat);
        $this->inner = $this->bytes->inner();
    }

    public function release(): void
    {
        $this->bytes->release();
    }

    public function wasm(): Types\Vec\Byte
    {
        $wasm = new Types\Vec\Byte();

        Runtime::wat2wasm($this->inner, $wasm->inner());

        return $wasm;
    }
}
