<?php declare(strict_types=1);

namespace Wasmer;

use FFI;
use Generator;
use Wasmer\Types\ImportType;
use Wasmer\Types\Vec\Byte;

final class Module extends Entity
{
    public function __construct(Store $store, Types\Vec\Byte $bytes)
    {
        $this->inner = Runtime::wasm_module_new($store->inner(), $bytes->inner());
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_module_delete($this->inner);
        }
    }

    /**
     * @psalm-return Generator<ImportType>
     */
    public function imports(): Generator
    {
        $importTypes = new Types\Vec\ImportType();

        Runtime::wasm_module_imports($this->inner, $importTypes->inner());

        $size = $importTypes->size();
        /**
         * @psalm-var array<FFI\CData>
         */
        $data = $importTypes->data();

        for ($i = 0; $i < $size; $i++) {
            yield (new ImportType($data[$i]))->unown();
        }
    }

    public static function validate(Store $store, Byte $bytes): bool
    {
        return Runtime::wasm_module_validate($store->inner(), $bytes->inner());
    }
}
