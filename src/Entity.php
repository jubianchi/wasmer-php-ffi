<?php declare(strict_types=1);

namespace Wasmer;

use FFI;

abstract class Entity implements Releasable, Ownable
{
    protected FFI\CData $inner;
    protected bool $owned = true;

    public function __destruct()
    {
        $this->release();
    }

    public function inner(): FFI\CData
    {
        return $this->inner;
    }

    public function unown(): static
    {
        $this->owned = false;

        return $this;
    }
}