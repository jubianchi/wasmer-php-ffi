<?php declare(strict_types=1);

namespace Wasmer\Types\Vec;

use FFI;
use Wasmer\Runtime;
use Wasmer\Types;

final class Val extends Types\Vec
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_val_vec_t*');

        $this->inner = $data;
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_val_vec_delete($this->inner);
        }
    }

    public static function sized(int $size): self
    {
        $vec = FFI::addr(Runtime::new('struct wasm_val_vec_t'));

        Runtime::wasm_val_vec_new_uninitialized($vec, $size);

        return new self($vec);
    }

    public static function new(Types\Val ...$vals): self
    {
        $vec = FFI::addr(Runtime::new('struct wasm_val_vec_t'));

        if (count($vals) === 0) {
            Runtime::wasm_val_vec_new_empty($vec);
        } else {
            $size = count($vals);
            $type = FFI::arrayType(Runtime::type('struct wasm_val_t'), [$size]);
            /**
             * @psalm-var array<FFI\CData>
             */
            $array = Runtime::new($type);

            foreach ($vals as $i => $val) {
                $array[$i] = $val->unown()->inner();
            }

            Runtime::wasm_val_vec_new($vec, $size, FFI::addr($array[0]));
        }

        return new self($vec);
    }
}
