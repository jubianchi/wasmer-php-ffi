<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;
use Wasmer\Types\Vec\Byte;

final class ValType extends Entity
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_valtype_t*');

        $this->inner = $data;
    }

    public function __debugInfo(): array
    {
        return ['kind' => $this->kind()];
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_valtype_delete($this->inner);
        }
    }

    public function kind(): Kind\Val
    {
        return Kind\Val::new(Runtime::wasm_valtype_kind($this->inner));
    }

    public static function new(Kind\Val $kind): self
    {
        return new self(Runtime::wasm_valtype_new($kind->value()));
    }
}
