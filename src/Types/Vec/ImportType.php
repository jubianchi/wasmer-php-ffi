<?php declare(strict_types=1);

namespace Wasmer\Types\Vec;

use FFI;
use Wasmer\Runtime;
use Wasmer\Types\Vec;

final class ImportType extends Vec
{
    public function __construct()
    {
        $this->inner = FFI::addr(Runtime::new("struct wasm_importtype_vec_t"));

        Runtime::wasm_importtype_vec_new_empty($this->inner);
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_importtype_vec_delete($this->inner);
        }
    }
}
