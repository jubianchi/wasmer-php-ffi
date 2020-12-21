<?php declare(strict_types=1);

namespace Wasmer;

use Wasmer\Exceptions\Logic;
use Wasmer\Types\Externalizable;
use Wasmer\Types\Func;
use Wasmer\Types\Glob;
use Wasmer\Types\Vec\Extern;

final class Imports implements Releasable
{
    /**
     * @var Externalizable[][]
     */
    private array $imports = [];
    private ?string $currentNamespace = null;
    private ?Types\Vec\Extern $externs = null;

    public function __destruct()
    {
        $this->release();
    }

    public function release(): void
    {
        if (null !== $this->externs) {
            $this->externs->release();
        }
    }

    public function func(string $name, Func $function): self
    {
        assert(null !== $this->currentNamespace, new Logic('undefined import namespace'));

        $this->release();

        $this->imports[$this->currentNamespace][$name] = $function;

        return $this;
    }

    public function global(string $name, Glob $glob): self
    {
        assert(null !== $this->currentNamespace, new Logic('undefined import namespace'));

        $this->release();

        $this->imports[$this->currentNamespace][$name] = $glob;

        return $this;
    }

    public function namespace(string $name = ''): self
    {
        if (!isset($this->imports[$name])) {
            $this->imports[$name] = [];
        }

        $this->currentNamespace = $name;

        return $this;
    }

    public function extern(Module $module): Extern
    {
        if (null !== $this->externs) {
            return $this->externs;
        }

        $imports = [];

        foreach ($module->imports() as $import) {
            $namespace = $import->module();
            $name = $import->name();

            if (isset($this->imports[$namespace][$name])) {
                $imports[] = $this->imports[$namespace][$name]->extern();
            }
        }

        $this->externs = Types\Vec\Extern::new(...$imports);

        return $this->externs;
    }
}