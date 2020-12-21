<?php declare(strict_types=1);

namespace Wasmer;

use FFI;
use Wasmer\Exceptions;

/**
 * @method static FFI\CData new(string|FFI\CType $type, bool $owned = true, bool $persistent = false)
 * @method static FFI\CType type(string|FFI\CType $type)
 *
 * @method static void wasm_byte_vec_new(FFI\CData $own__wasm_byte_vec_t_ptr__out, int $size_t, string $own__wasm_byte_t_const_array)
 * @method static void wasm_byte_vec_new_empty(FFI\CData $own__wasm_byte_vec_t_ptr__out)
 * @method static void wasm_byte_vec_delete(FFI\CData $own__wasm_byte_vec_t_ptr)
 *
 * @method static FFI\CData wasm_engine_new() Returns an owned Engine
 * @method static void wasm_engine_delete(FFI\CData $own__wasm_engine_t_ptr)
 *
 * @method static void wasm_extern_delete(FFI\CData $own__wasm_extern_t_ptr)
 * @method static void wasm_extern_vec_new_empty(FFI\CData $own__wasm_extern_vec_t_ptr__out)
 * @method static void wasm_extern_vec_new(FFI\CData $own__wasm_extern_vec_t_ptr__out, int $size_t, FFI\CData $own__wasm_extern_t_ptr_const_array)
 * @method static void wasm_extern_vec_new_uninitialized(FFI\CData $own__wasm_extern_vec_t_ptr__out, int $size_t)
 * @method static void wasm_extern_vec_delete(FFI\CData $own__wasm_extern_vec_t_ptr)
 * @method static FFI\CData wasm_extern_as_func(FFI\CData $wasm_extern_t_ptr)
 * @method static FFI\CData wasm_extern_as_global(FFI\CData $wasm_extern_t_ptr)
 * @method static FFI\CData wasm_extern_as_memory(FFI\CData $wasm_extern_t_ptr)
 *
 * @method static void wasm_externtype_delete(FFI\CData $own__wasm_externtype_t_ptr)
 *
 * @method static void wasm_importtype_vec_new_empty(FFI\CData $own__wasm_importtype_vec_t_ptr__out)
 * @method static void wasm_importtype_vec_delete(FFI\CData $own__wasm_importtype_vec_t_ptr)
 *
 * @method static FFI\CData wasm_instance_new(FFI\CData $wasm_store_t_ptr, FFI\CData $const_wasm_module_t_ptr, FFI\CData $const_wasm_extern_vec_t_ptr, ?FFI\CData[] $own__wasm_trap_t_ptr_ptr) Returns an owned Instance
 * @method static void wasm_instance_delete(FFI\CData $own__wasm_instance_t_ptr)
 *
 * @method static FFI\CData wasm_func_new(FFI\CData $wasm_store_t_ptr, FFI\CData $const_wasm_functype_t_ptr, callable $wasm_func_callback_t_ptr) Returns an owned Func
 * @method static void wasm_func_delete(FFI\CData $own__wasm_func_t_ptr)
 * @method static int wasm_func_param_arity(FFI\CData $wasm_func_t_ptr)
 * @method static int wasm_func_result_arity(FFI\CData $wasm_func_t_ptr)
 * @method static FFI\CData wasm_func_as_extern(FFI\CData $wasm_func_t_ptr)
 *
 * @method static FFI\CData wasm_functype_new(FFI\CData $own__wasm_valtype_vec_t_ptr__params, FFI\CData $own__wasm_valtype_vec_t_ptr__results) Returns an owned FuncType
 * @method static void wasm_functype_delete(FFI\CData $own__wasm_functype_t_ptr)
 * @method static FFI\CData wasm_functype_as_externtype(FFI\CData $wasm_functype_t_ptr)
 *
 * @method static FFI\CData wasm_global_new($wasm_store_t_ptr, $const_wasm_globaltype_t_ptr, $const_wasm_val_t_ptr) Returns an owned Glob
 * @method static FFI\CData wasm_global_type(FFI\CData $const_wasm_global_t_ptr) Returns an owned GlobalType
 * @method static FFI\CData wasm_global_as_extern(FFI\CData $wasm_global_t_ptr)
 *
 * @method static FFI\CData wasm_globaltype_new(FFI\CData $own__wasm_valtype_t_ptr, $wasm_mutability_t) Returns an owned GlobalType
 * @method static FFI\CData wasm_globaltype_content(FFI\CData $const_wasm_global_t_ptr)
 * @method static int wasm_globaltype_mutability(FFI\CData $const_wasm_global_t_ptr)
 * @method static FFI\CData wasm_globaltype_as_externtype(FFI\CData $wasm_globaltype_t_ptr)
 *
 * @method static FFI\CData wasm_memory_new(FFI\CData $wasm_store_t_ptr, FFI\CData $const_wasm_memorytype_t_ptr) Returns an owned Memory
 * @method static FFI\CData wasm_memory_type(FFI\CData $const_wasm_memory_t_ptr)
 * @method static void wasm_memory_delete(FFI\CData $own__wasm_memory_t_ptr)
 * @method static FFI\CData wasm_memory_as_extern(FFI\CData $wasm_memory_t_ptr)
 *
 * @method static FFI\CData wasm_memorytype_new(FFI\CData $const_wasm_limits_t_ptr) Returns an owned MemoryType
 * @method static FFI\CData wasm_memorytype_limits(FFI\CData $const_wasm_memorytype_t_ptr)
 * @method static void wasm_memorytype_delete(FFI\CData $own__wasm_memorytype_t_ptr)
 * @method static FFI\CData wasm_memorytype_as_externtype(FFI\CData $wasm_memorytype_t_ptr)
 *
 * @method static FFI\CData wasm_importtype_new(FFI\CData $own__wasm_name_t_ptr__module, FFI\CData $own__wasm_name_t_ptr__name, FFI\CData $own__wasm_externtype_t_ptr) Returns an owned ImportType
 * @method static void wasm_importtype_delete(FFI\CData $own__wasm_importtype_t_ptr)
 * @method static FFI\CData wasm_importtype_module(FFI\CData $const_wasm_importtype_t_ptr)
 * @method static FFI\CData wasm_importtype_name(FFI\CData $const_wasm_importtype_t_ptr)
 *
 * @method static FFI\CData wasm_module_new(FFI\CData $wasm_store_t_ptr, FFI\CData $const_wasm_byte_vec_t_ptr__binary) Returns an owned Module
 * @method static void wasm_module_delete(FFI\CData $own__wasm_module_t_ptr)
 * @method static void wasm_module_imports(FFI\CData $const_wasm_module_t_ptr, FFI\CData $own__wasm_importtype_vec_t__out)
 * @method static bool wasm_module_validate(FFI\CData $const_wasm_module_t_ptr, FFI\CData $const_wasm_byte_vec_t_ptr__binary)
 *
 * @method static FFI\CData wasm_store_new(FFI\CData $wasm_engine_t_ptr) Returns an owned Store
 * @method static void wasm_store_delete(FFI\CData $own__wasm_store_t_ptr)
 *
 * @method static FFI\CData wasm_valtype_new(int $wasm_valking_t) Returns an owned ValType
 * @method static int wasm_valtype_kind(FFI\CData $const_wasm_valtype_t_ptr)
 * @method static void wasm_valtype_delete(FFI\CData $own__wasm_valtype_t_ptr)
 *
 * @method static void wasm_valtype_vec_new(FFI\CData $own__wasm_valtype_vec_t_ptr__out, $size_t, $own__wasm_valtype_t_ptr_const_array)
 * @method static void wasm_valtype_vec_new_empty(FFI\CData $own__wasm_valtype_vec_t_ptr__out)
 * @method static void wasm_valtype_vec_delete(FFI\CData $own__wasm_valtype_vec_t_ptr)
 *
 * @method static void wasm_val_vec_new(FFI\CData $own__wasm_val_vec_t_ptr__out, $size_t, $own__wasm_val_t_ptr_const_array)
 * @method static void wasm_val_vec_new_empty(FFI\CData $own__wasm_val_vec_t_ptr__out)
 * @method static void wasm_val_vec_new_uninitialized(FFI\CData $own__wasm_val_vec_t_ptr__out, $size_t)
 * @method static void wasm_val_vec_delete(FFI\CData $own__wasm_val_vec_t_ptr)
 *
 * @method static FFI\CData wasm_trap_new($wasm_store_t_ptr__store, $const_wasm_message_t_ptr) Returns an owned Trap
 * @method static FFI\CData wasm_trap_message($const_wasm_trap_t_ptr, $own__wasm_message_t_ptr__out)
 *
 * @method static int wasmer_last_error_length()
 * @method static int wasmer_last_error_message(FFI\CData $char_ptr__buffer, int $length)
 * @method static wat2wasm(FFI\CData $const_wasm_byte_vec_t_ptr__wat, FFI\CData $own__wasm_byte_vec_t_ptr__out)
 * @method static string wasmer_version()
 * @method static int wasmer_version_major()
 * @method static int wasmer_version_minor()
 * @method static int wasmer_version_patch()
 * @method static string wasmer_version_pre()
 */
final class Runtime {
    private static FFI $inner;

    public static function __callStatic(string $name, array $arguments)
    {
        return self::$inner->$name(...$arguments);
    }

    public static function init(): void
    {
        try {
            $lib = self::locateLibrary();
        } catch (Exceptions\Runtime $exception) {
            throw new Exceptions\Unsupported('This operating system is not supported', (int) $exception->getCode(), $exception);
        }

        self::$inner = FFI::cdef(
            file_get_contents(__DIR__ . '/../package/include/wasmer_wasm_expanded.h'),
            $lib
        );
    }

    public static function inner(): FFI
    {
        return self::$inner;
    }

    public static function lastErrorLength(): int
    {
        return self::wasmer_last_error_length();
    }

    public static function lastErrorMessage(): ?string
    {
        $length = self::lastErrorLength();

        if ($length > 0) {
            $type = FFI::arrayType(self::$inner->type('char'), [$length]);
            $buffer = self::new($type);

            /**
             * @psalm-suppress MixedArgument
             */
            self::wasmer_last_error_message(FFI::addr($buffer[0]), $length);

            return FFI::string(FFI::addr($buffer), $length);
        }

        return null;
    }

    public static function version(?string $part = null): string
    {
        switch ($part) {
            case 'major':
            case 'minor':
            case 'patch':
                return (string) self::{'wasmer_version_'.$part}();

            case 'pre':
                return self::wasmer_version_pre();

            default:
                return self::wasmer_version();
        }
    }

    /**
     * @psalm-return array{arch: string, vendor: string, os: string}
     */
    private static function getOsTriplet(): array
    {
        return [
            'arch' => php_uname('m'),
            'vendor' => 'unknown',
            'os' => strtolower((string) PHP_OS_FAMILY),
        ];
    }

    private static function locateLibrary(): string
    {
        ['arch' => $arch, 'vendor' => $vendor, 'os' => $os] = self::getOsTriplet();
        $lib = sprintf(
            __DIR__ . '/../package/lib/%s-%s-%s/libwasmer.%s',
            $arch,
            $vendor,
            $os,
            'darwin' === $os ? 'dylib' : PHP_SHLIB_SUFFIX,
        );

        if (!file_exists($lib)) {
            throw new Exceptions\Runtime(
                sprintf('Could not find library for %s-%s-%s', $arch, $vendor, $os),
                Exceptions\Codes::LOCATE_LIBRARY
            );
        }

        return $lib;
    }
}
