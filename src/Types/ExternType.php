<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;

final class ExternType extends Entity
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_externtype_t*');

        $this->inner = $data;
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_externtype_delete($this->inner);
        }
    }
}
