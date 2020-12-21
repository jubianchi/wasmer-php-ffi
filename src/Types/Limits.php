<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;
use Wasmer\Runtime;

final class Limits extends Entity
{
    public const MAX = 0xffffffff;

    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_limits_t*');

        $this->inner = $data;
    }

    public function __debugInfo(): array
    {
        return ['min' => $this->min(), 'max' => $this->max()];
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            FFI::free($this->inner);
        }
    }

    public function min(): Pages
    {
        /**
         * @psalm-suppress UndefinedPropertyFetch
         */
        return Pages::new((int) $this->inner->min);
    }

    public function max(): Pages
    {
        /**
         * @psalm-suppress UndefinedPropertyFetch
         */
        return Pages::new((int) $this->inner->max);
    }

    public static function new(Pages $min, ?Pages $max = null): self
    {
        $limits = Runtime::new('struct wasm_limits_t');

        /**
         * @psalm-suppress UndefinedPropertyAssignment
         */
        $limits->min = $min->size();

        /**
         * @psalm-suppress UndefinedPropertyAssignment
         */
        $limits->max = $max === null ? self::MAX : $max->size();

        return new self(FFI::addr($limits));
    }
}
