<?php

namespace {
    class FFI
    {
        /** @see https://www.php.net/manual/en/ffi.addr.php */
        public static function addr(FFI\CData &$ptr): FFI\CData {}
        /** @see https://www.php.net/manual/en/ffi.alignof.php */
        public static function alignof(FFI\CData|FFI\CType &$ptr): int {}
        /** @see https://www.php.net/manual/en/ffi.arrayType.php */
        public static function arrayType(FFI\CType $type, array $dims): FFI\CType {}
        /** @see https://www.php.net/manual/en/ffi.cast.php */
        public static function cast(string|FFI\CType $type, FFI\CData &$ptr): FFI\CData {}
        /**
         * @see https://www.php.net/manual/en/ffi.cdef.php
         *
         * @throws FFI\ParserException
         */
        public static function cdef(string $code = '', string ...$lib): FFI {}
        /** @see https://www.php.net/manual/en/ffi.free.php */
        public static function free(FFI\CData &$ptr): void {}
        /** @see https://www.php.net/manual/en/ffi.isnull.php */
        public static function isNull(FFI\CData &$ptr): bool {}
        /** @see https://www.php.net/manual/en/ffi.load.php */
        public static function load(string $filename): FFI {}
        /** @see https://www.php.net/manual/en/ffi.memcmp.php */
        public static function memcmp(string|FFI\CData &$ptr1, string|FFI\CData &$ptr2, int $size): int {}
        /** @see https://www.php.net/manual/en/ffi.memcpy.php */
        public static function memcpy(string|FFI\CData &$dst, string|FFI\CData &$src, int $size): void {}
        /** @see https://www.php.net/manual/en/ffi.memset.php */
        public static function memset(FFI\CData &$ptr, int $ch, int $size): void {}
        /**
         * @see https://www.php.net/manual/en/ffi.new.php
         *
         * @throws FFI\ParserException
         */
        public static function new(string|FFI\CType $type, bool $owned = true, bool $persistent = false): FFI\CData {}
        /** @see https://www.php.net/manual/en/ffi.scope.php */
        public static function scope(string $scope_name): FFI {}
        /** @see https://www.php.net/manual/en/ffi.sizeof.php */
        public static function sizeof(FFI\CData|FFI\CType &$ptr): int {}
        /** @see https://www.php.net/manual/en/ffi.string.php */
        public static function string(FFI\CData &$ptr, ?int $size = null): string {}
        /** @see https://www.php.net/manual/en/ffi.type.php */
        public static function type(string|FFI\CType $type): FFI\CType {}
        /** @see https://www.php.net/manual/en/ffi.typeof.php */
        public static function typeof(FFI\CData &$ptr): FFI\CType {}

        /** @see https://www.php.net/manual/en/ffi.cast.php */
        public function cast(string|FFI\CType $type, FFI\CData &$ptr): FFI\CData {}
        /**
         * @see https://www.php.net/manual/en/ffi.new.php
         *
         * @throws FFI\ParserException
         */
        //public function new(string|FFI\CType $type, bool $owned = true, bool $persistent = false): FFI\CData {}
        /** @see https://www.php.net/manual/en/ffi.typeof.php */
        public function type(string|FFI\CType $type): FFI\CType {}
    }
}

namespace FFI {
    class Exception extends \Error
    {
    }

    class ParserException extends Exception
    {
    }

    class CData
    {
    }

    class CType
    {
        public function getName(): string {}
    }
}
