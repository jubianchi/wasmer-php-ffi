<?php declare(strict_types=1);

namespace Wasmer;

use FFI;

final class Engine extends Entity
{
    public function __construct()
    {
        $this->inner = Runtime::wasm_engine_new();
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_engine_delete($this->inner);
        }
    }
}
