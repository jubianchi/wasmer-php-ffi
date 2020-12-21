<?php declare(strict_types=1);

namespace Wasmer\Exceptions;

use Wasmer\Exception;
use Wasmer\Store;
use Wasmer\Types;

class Trap extends \RuntimeException implements Exception
{
    public function trap(Store $store): Types\Trap
    {
        return Types\Trap::new($store, new Types\Vec\Byte($this->getMessage()));
    }
}
