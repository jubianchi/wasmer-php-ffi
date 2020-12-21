<?php declare(strict_types=1);

namespace Wasmer\Types\Vec;

use FFI;
use Wasmer\Runtime;
use Wasmer\Types;

final class ValType extends Types\Vec
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_valtype_vec_t*');

        $this->inner = $data;
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_valtype_vec_delete($this->inner);
        }
    }

    public static function new(Types\ValType ...$types): self
    {
        /**
         * @psalm-var FFI\CData
         */
        $vec = FFI::addr(Runtime::new('struct wasm_valtype_vec_t'));

        if (count($types) === 0) {
            Runtime::wasm_valtype_vec_new_empty($vec);
        } else {
            $size = count($types);
            $type = FFI::arrayType(Runtime::type('struct wasm_valtype_t*'), [$size]);
            /**
             * @psalm-var array<FFI\CData>
             */
            $array = Runtime::new($type);

            foreach ($types as $i => $type) {
                $array[$i] = $type->unown()->inner();
            }

            Runtime::wasm_valtype_vec_new($vec, $size, $array);
        }

        return new self($vec);
    }
}
