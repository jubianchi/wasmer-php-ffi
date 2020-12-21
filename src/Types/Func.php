<?php declare(strict_types=1);

namespace Wasmer\Types;

use Exception;
use FFI;
use Wasmer\Entity;
use Wasmer\Exceptions;
use Wasmer\Runtime;
use Wasmer\Store;
use Wasmer\Types\Vec\Byte;

final class Func extends Entity implements Externalizable
{
    public function __construct(FFI\CData $data)
    {
        assert(FFI::typeof($data)->getName() === 'struct wasm_func_t*');

        $this->inner = $data;
    }

    public function __invoke(int|float ...$args): array
    {
        if (count($args) !== $this->paramArity()) {
            throw new Exceptions\InvalidFunctionCall(sprintf('Expected %d argument, got %d', $this->paramArity(), count($args)));
        }

        $vals = [];

        foreach ($args as $index => $arg) {
            switch (gettype($arg)) {
                case 'integer':
                    $vals[$index] = Val::new(Kind\Val::I32(), $arg);
                    break;

                case 'double':
                    $vals[$index] = Val::new(Kind\Val::F32(), $arg);
                    break;

                // TODO(jubianchi): Implement default
            }
        }

        $params = \Wasmer\Types\Vec\Val::new(...$vals);

        $results = $this->call($params);
        $rets = [];
        $size = $results->size();
        /**
         * @psalm-var array<FFI\CData>
         */
        $data = $results->data();

        for ($i = 0; $i < $size; $i++) {
            switch ($data[$i]->kind) {
                case Kind\Val::I32()->value():
                    $rets[] = $data[$i]->of->i32;
                    break;

                case Kind\Val::F32()->value():
                    $rets[] = $data[$i]->of->f32;
                    break;

                case Kind\Val::I64()->value():
                    $rets[] = $data[$i]->of->i64;
                    break;

                case Kind\Val::F64()->value():
                    $rets[] = $data[$i]->of->f64;
                    break;

                // TODO(jubianchi): Implement default
            }
        }

        return $rets;
    }

    public function __toString(): string
    {
        return self::class;
    }

    public function call(Vec\Val $params): Vec\Val
    {
        if ($params->size() !== $this->paramArity()) {
            throw new Exceptions\InvalidFunctionCall(sprintf('Expected %d argument, got %d', $this->paramArity(), count($args)));
        }

        $results = Vec\Val::sized($this->resultArity());

        Runtime::wasm_func_call($this->inner, $params->inner(), $results->unown()->inner());

        return $results;
    }

    public function release(): void
    {
        if ($this->owned && !FFI::isNull($this->inner)) {
            Runtime::wasm_func_delete($this->inner);
        }
    }

    public function extern(): Extern
    {
        return Extern::new($this);
    }

    public function paramArity(): int
    {
        return Runtime::wasm_func_param_arity($this->inner);
    }

    public function resultArity(): int
    {
        return Runtime::wasm_func_result_arity($this->inner);
    }

    public static function new(Store $store, FuncType $type, callable $function): self
    {
        $callback = function (FFI\CData $args, FFI\CData $rets) use ($store, $function): ?FFI\CData {
            $o = [];

            for ($i = 0; $i < $args->size; $i++) {
                $arg = (new Val($args->data[$i]))->unown();

                switch ($arg->kind()) {
                    case Kind\Val::I32():
                        $o[] = $arg->of()->i32;
                        break;

                    case Kind\Val::I64():
                        $o[] = $arg->of()->i64;
                        break;

                    case Kind\Val::F32():
                        $o[] = $arg->of()->f32;
                        break;

                    case Kind\Val::F64():
                        $o[] = $arg->of()->f64;
                        break;

                    //TODO(jubianchi): Implement AnyRef
                    //TODO(jubianchi): Implement FuncRef
                    //TODO(jubianchi): Implement default
                }
            }

            try {
                /**
                 * @psalm-var int|float|array<int|float>
                 */
                $result = $function(...$o);

                if (is_array($result)) {
                    foreach ($result as $i => $value) {
                        $rets->data[$i] = self::val($value)->unown()->inner();
                    }
                } else {
                    $rets->data[0] = self::val($result)->unown()->inner();
                }
            } catch (Exceptions\Trap $exception) {
                return $exception->trap($store)->unown()->inner();
            } catch (Exception $exception) {
                return Trap::new($store, new Byte($exception->getMessage()))->unown()->inner();
            }

            return null;
        };

        return new self(Runtime::wasm_func_new($store->inner(), $type->inner(), $callback));
    }

    public static function from(Store $store, callable $function): self
    {
        $reflection = new \ReflectionFunction(\Closure::fromCallable($function));
        $parameters = [];

        foreach ($reflection->getParameters() as $i => $parameter) {
            $parameters[] = self::type($parameter->getType() ?? throw new Exceptions\Runtime(sprintf("Parameter #%d ($%s) of %s must have a type annotation", $i + 1, $parameter->getName(), $reflection->getName())));
        }

        $return = $reflection->getReturnType();
        $returns = [];

        if (null !== $return && 'void' !== (string) $return) {
            $returns[] = self::type($return);
        }

        $type = FuncType::new(
            \Wasmer\Types\Vec\ValType::new(...$parameters),
            \Wasmer\Types\Vec\ValType::new(...$returns),
        );

        return self::new($store, $type, $function);
    }

    private static function type(\ReflectionType $type): ValType
    {
        switch ($type) {
            case 'int':
                return ValType::new(Kind\Val::I32());

            case 'float':
                return ValType::new(Kind\Val::F32());

            default:
                throw new Exceptions\Runtime(sprintf('Type %s is not supported', (string) $type));
        }
    }

    private static function val(int|float $value): Val
    {
        switch (gettype($value)) {
            case 'integer':
                return Val::newI32($value);

            case 'float':
                return Val::newF32($value);

            default:
                throw new Exceptions\Runtime(sprintf('Type %s is not supported', (string) $type));
        }
    }
}