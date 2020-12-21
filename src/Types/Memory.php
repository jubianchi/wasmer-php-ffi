<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;
use Wasmer\Store;

final class Memory extends Entity implements Externalizable
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_memory_t*');

        $this->inner = $data;
    }

    public function __debugInfo(): array
    {
        return ['ty' => $this->ty()];
    }

    public function __toString(): string
    {
        return self::class;
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_memory_delete($this->inner);
        }
    }

    public function extern(): Extern
    {
        return Extern::new($this);
    }

    public function ty(): MemoryType
    {
        return new MemoryType(Runtime::wasm_memory_type($this->inner));
    }

    public static function new(Store $store, MemoryType $type): self
    {
        return new self(Runtime::wasm_memory_new($store->inner(), $type->inner()));
    }
}
