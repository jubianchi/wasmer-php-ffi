<?php declare(strict_types=1);

namespace Wasmer\Types;

use FFI;
use Wasmer\Entity;

abstract class Vec extends Entity
{
    public function size(): int
    {
        return (int) $this->inner->size;
    }

    public function data(): FFI\CData
    {
        return $this->inner->data;
    }
}
