<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;

final class MemoryType extends Entity
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_memorytype_t*');

        $this->inner = $data;
    }

    public function __debugInfo(): array
    {
        return ['limits' => $this->limits()];
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_memorytype_delete($this->inner);
        }
    }

    public function externType(): ExternType
    {
        return (new ExternType(Runtime::wasm_memorytype_as_externtype($this->inner)))->unown();
    }

    public function limits(): Limits
    {
        return (new Limits(Runtime::wasm_memorytype_limits($this->inner)))->unown();
    }

    public static function new(Limits $limits): self
    {
        return new self(Runtime::wasm_memorytype_new($limits->inner()));
    }
}
