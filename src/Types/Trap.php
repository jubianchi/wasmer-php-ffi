<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;
use Wasmer\Store;
use Wasmer\Types\Vec\Byte;

final class Trap extends Entity
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_trap_t*');

        $this->inner = $data;
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_trap_delete($this->inner);
        }
    }

    public function message(): string
    {
        $message = new Byte();
        Runtime::wasm_trap_message($this->inner, $message->inner());

        return (string) $message;
    }

    public static function new(Store $store, Byte $message): self
    {
        return new self(Runtime::wasm_trap_new($store->inner(), $message->inner()));
    }
}
