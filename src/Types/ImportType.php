<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;
use Wasmer\Types\Vec\Byte;

final class ImportType extends Entity
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_importtype_t*');

        $this->inner = $data;
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_importtype_delete($this->inner);
        }
    }

    public function module(): string
    {
        return (string) Byte::from(Runtime::wasm_importtype_module($this->inner));
    }

    public function name(): string
    {
        return (string) Byte::from(Runtime::wasm_importtype_name($this->inner));
    }

    public static function new(Byte $module, Byte $name, ExternType $type): self
    {
        return new self(
            Runtime::wasm_importtype_new(
                $module->unown()->inner(),
                $name->unown()->inner(),
                $type->unown()->inner()
            )
        );
    }
}
