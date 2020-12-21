<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Exceptions;
use Wasmer\Runtime;

final class Extern extends Entity
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_extern_t*');

        $this->inner = $data;
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_extern_delete($this->inner);
        }
    }

    public function func(): Func
    {
        return new Func(Runtime::wasm_extern_as_func($this->inner));
    }

    public function global(): Glob
    {
        return new Glob(Runtime::wasm_extern_as_global($this->inner));
    }

    public function memory(): Memory
    {
        return new Memory(Runtime::wasm_extern_as_memory($this->inner));
    }

    //TODO(jubianchi): Implement Table

    public static function new(Func|Glob|Memory $entity): self
    {
        $class = $entity::class;

        switch ($class) {
            case Func::class:
                return new self(Runtime::wasm_func_as_extern($entity->inner()));

            case Glob::class:
                return new self(Runtime::wasm_global_as_extern($entity->inner()));

            case Memory::class:
                return new self(Runtime::wasm_memory_as_extern($entity->inner()));

            //TODO(jubianchi): Implement Table

            default:
                throw new Exceptions\Runtime(sprintf('Extern %s is not supported', $class));
        }
    }
}