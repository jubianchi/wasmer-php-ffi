<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;

final class Val extends Entity
{
    private FFI\CData $ptr;

    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_val_t');

        $this->inner = $data;
        $this->ptr = FFI::addr($data);
    }

    public function __toString(): string
    {
        switch ($this->kind()) {
            case Kind\Val::I32():
                return (string) (int) $this->inner->of->i32;

            case Kind\Val::I64():
                return (string) (int) $this->inner->of->i64;

            case Kind\Val::F32():
                return (string) (float) $this->inner->of->f32;

            case Kind\Val::F64():
                return (string) (float) $this->inner->of->f64;

            // TODO(jubianchi): Implement AnyRef
            // TODO(jubianchi): Implement FuncRef

            default:
                throw new \Wasmer\Exceptions\Runtime(sprintf('Unsupported kind "%s" for "%s"', $this->kind()->value(), self::class));
        }
    }

    public function equals(self $val)
    {
        /**
         * @psalm-suppress UndefinedPropertyFetch
         */
        $self = Kind\Val::new($this->inner->kind);

        /**
         * @psalm-suppress UndefinedPropertyFetch
         */
        $other = Kind\Val::new($val->inner->kind);

        return $self === $other && (
                ($self === Kind\Val::I32() && $this->inner->of->i32 === $val->inner->of->i32) ||
                ($self === Kind\Val::F32() && $this->inner->of->f32 === $val->inner->of->f32) ||
                ($self === Kind\Val::I64() && $this->inner->of->i64 === $val->inner->of->i64) ||
                ($self === Kind\Val::F64() && $this->inner->of->f64 === $val->inner->of->f64)

                // TODO(jubianchi): Implement AnyRef
                // TODO(jubianchi): Implement FuncRef
            );
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->ptr)) {
            //Runtime::wasm_val_delete($this->ptr);
            FFI::free($this->ptr);
        }
    }

    public function kind(): Kind\Val
    {
        return Kind\Val::new($this->inner->kind);
    }

    public function of(): object
    {
        return $this->inner->of;
    }

    public static function new(Kind\Val $kind, int|float $value): self
    {
        $val = Runtime::new('struct wasm_val_t');

        switch ($kind) {
            case Kind\Val::I32():
                $val->kind = $kind->value();
                $val->of->i32 = (int) $value;
                break;

            case Kind\Val::I64():
                $val->kind = $kind->value();
                $val->of->i64 = (int) $value;
                break;

            case Kind\Val::F32():
                $val->kind = $kind->value();
                $val->of->f32 = (float) $value;
                break;

            case Kind\Val::F64():
                $val->kind = $kind->value();
                $val->of->f64 = (float) $value;
                break;

            //TODO(jubianchi): Implement AnyRef
            //TODO(jubianchi): Implement FuncRef
            // TODO(jubianchi): Implement default
        }

        return new self($val);
    }

    public static function newI32(int $value): self
    {
        return self::new(Kind\Val::I32(), $value);
    }

    public static function newI64(int $value): self
    {
        return self::new(Kind\Val::I64(), $value);
    }

    public static function newF32(float $value): self
    {
        return self::new(Kind\Val::F32(), $value);
    }

    public static function newF64(float $value): self
    {
        return self::new(Kind\Val::F64(), $value);
    }
}