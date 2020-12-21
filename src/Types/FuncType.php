<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;

final class FuncType extends Entity
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_functype_t*');

        $this->inner = $data;
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_functype_delete($this->inner);
        }
    }

    public function externType(): ExternType
    {
        return (new ExternType(Runtime::wasm_functype_as_externtype($this->inner)))->unown();
    }

    public static function new(Vec\ValType $params, Vec\ValType $results): self
    {
        return new self(Runtime::wasm_functype_new($params->unown()->inner(), $results->unown()->inner()));
    }
}
