<?php declare(strict_types=1);

namespace Wasmer;

use FFI;

final class Store extends Entity
{
    public function __construct(Engine $engine)
    {
        $this->inner = Runtime::wasm_store_new($engine->inner());
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_store_delete($this->inner);
        }
    }
}
