<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;

final class GlobalType extends Entity
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_globaltype_t*');

        $this->inner = $data;
    }

    public function __debugInfo(): array
    {
        return [
            'mutability' => $this->mutability(),
            'content' => $this->content(),
        ];
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_globaltype_delete($this->inner);
        }
    }

    public function externType(): ExternType
    {
        return (new ExternType(Runtime::wasm_globaltype_as_externtype($this->inner)))->unown();
    }

    public function mutability(): Mutability
    {
        return Mutability::new(Runtime::wasm_globaltype_mutability($this->inner));
    }

    public function content(): ValType
    {
        return (new ValType(Runtime::wasm_globaltype_content($this->inner)))->unown();
    }

    public static function new(ValType $type, Mutability $mutability): self
    {
        return new self(Runtime::wasm_globaltype_new($type->unown()->inner(), $mutability->value()));
    }
}
