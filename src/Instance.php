<?php declare(strict_types=1);

namespace Wasmer;

use FFI;
use TypeError;
use Wasmer\Types\Trap;
use Wasmer\Types\Vec;

final class Instance extends Entity
{
    /**
     * @throws Exceptions\Instantiation
     */
    public function __construct(Store $store, Module $module, Imports $imports)
    {
        $type = FFI::arrayType(Runtime::type('wasm_trap_t*'), [1]);

        /**
         * @psalm-var array<FFI\CData>
         */
        $traps = FFI::new($type);

        try {
            $this->inner = Runtime::wasm_instance_new(
                $store->inner(),
                $module->inner(),
                $imports->extern($module)->inner(),
                $traps
            );
        } catch (TypeError $error) {
            if (!FFI::isNull($traps[0])) {
                $trap = new Trap($traps[0]);

                throw new Exceptions\Trap($trap->message());
            }

            throw new Exceptions\Instantiation(Runtime::lastErrorMessage() ?? 'Unexpected error: '.$error);
        }
    }

    public function exports(): Vec\Extern
    {
        $vec = FFI::addr(Runtime::new("struct wasm_extern_vec_t"));
        Runtime::wasm_extern_vec_new_uninitialized($vec, 1);

        Runtime::wasm_instance_exports($this->inner, $vec);

        return (new Vec\Extern($vec))->unown();
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_instance_delete($this->inner);
        }
    }
}
