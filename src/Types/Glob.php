<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;
use Wasmer\Store;

final class Glob extends Entity implements Externalizable
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_global_t*');

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
            Runtime::wasm_global_delete($this->inner);
        }
    }

    public function extern(): Extern
    {
        return Extern::new($this);
    }

    public function ty(): GlobalType
    {
        return new GlobalType(Runtime::wasm_global_type($this->inner));
    }

    public static function new(Store $store, GlobalType $type, Val $value): self
    {
        return new self(Runtime::wasm_global_new($store->inner(), $type->inner(), FFI::addr($value->unown()->inner())));
    }
}
