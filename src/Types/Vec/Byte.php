<?php declare(strict_types=1);

namespace Wasmer\Types\Vec;

use FFI;
use Wasmer\Runtime;
use Wasmer\Types\Vec;

final class Byte extends Vec
{
    public function __construct(?string $bytes = null)
    {
        $this->inner = FFI::addr(Runtime::new("struct wasm_byte_vec_t"));

        if (null === $bytes) {
            Runtime::wasm_byte_vec_new_empty($this->inner);
        } else {
            Runtime::wasm_byte_vec_new($this->inner, strlen($bytes), $bytes);
        }
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_byte_vec_delete($this->inner);
        }
    }

    public function __toString(): string
    {
        $source = $this->data();
        $size = $this->size();

        return \FFI::string($source, $size);
    }

    /**
     * @psalm-type WasmNameT object{data: FFI\CData, size: FFI\CData}
     */
    public static function from(FFI\CData $data): self
    {
        /**
         * @psalm-var WasmNameT $data
         */

        $source = $data->data;
        $size = (int) $data->size;

        return new self(FFI::string($source, $size));
    }
}
