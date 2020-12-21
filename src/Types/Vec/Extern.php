<?php declare(strict_types=1);

namespace Wasmer\Types\Vec;

use FFI;
use Wasmer\Runtime;
use Wasmer\Types;

final class Extern extends Types\Vec
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_extern_vec_t*');

        $this->inner = $data;
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_extern_vec_delete($this->inner);
        }
    }

    public function get(int $index): Types\Extern
    {
        return new Types\Extern($this->data()[$index]);
    }

    public static function new(Types\Extern ...$externs): self
    {
        $vec = FFI::addr(Runtime::new("struct wasm_extern_vec_t"));

        if (count($externs) === 0) {
            Runtime::wasm_extern_vec_new_empty($vec);
        } else {
            $size = count($externs);
            $type = FFI::arrayType(Runtime::type('struct wasm_extern_t*'), [$size]);
            /**
             * @psalm-var array<FFI\CData>
             */
            $array = Runtime::new($type, false);

            foreach ($externs as $i => $extern) {
                $array[$i] = $extern->unown()->inner();
            }

            // TODO(jubianchi): Review the implementation of array here (see Vec\ValType)
            Runtime::wasm_extern_vec_new($vec, $size, FFI::addr($array[0]));
        }

        return new self($vec);
    }
}
