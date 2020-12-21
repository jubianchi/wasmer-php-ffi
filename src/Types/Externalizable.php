<?php declare(strict_types=1);

namespace Wasmer\Types;

interface Externalizable
{
    public function extern(): Extern;
}
