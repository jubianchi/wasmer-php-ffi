<?php declare(strict_types=1);

namespace Wasmer;

interface Ownable
{
    public function unown(): static;
}