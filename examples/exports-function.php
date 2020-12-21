<?php declare(strict_types=1);

use Wasmer\{Engine, Imports, Instance, Module, Runtime, Store, Types, Types\Val, Wat};

require_once __DIR__ . '/../vendor/autoload.php';

Runtime::init();
var_dump(Runtime::version());

$wat = new Wat(<<<'WAT'
(module
  (type $sum_t (func (param i32 i32) (result i32)))
  (func $sum_f (type $sum_t) (param $x i32) (param $y i32) (result i32)
    local.get $x
    local.get $y
    i32.add)
  (export "sum" (func $sum_f)))
WAT);

echo "Creating engine..." . PHP_EOL;
$engine = new Engine();

echo "Creating store..." . PHP_EOL;
$store = new Store($engine);

echo "Compiling module..." . PHP_EOL;
$module = new Module($store, $wat->wasm());

unset($wat);

$imports = new Imports();

echo "Instantiating module..." . PHP_EOL;
$instance = new Instance($store, $module, $imports);

echo "Getting the `sum` function..." . PHP_EOL;
$sum = $instance->exports()->get(0)->func();

echo "Calling `sum` function...".PHP_EOL;
$params = Types\Vec\Val::new(
    Val::new(Types\Kind\Val::I32(), 1),
    Val::new(Types\Kind\Val::I32(), 2),
);
$result = $sum->call($params);

assert($result->size() === 1);
$expected = Val::newI32(3);
$actual = new Val($result->data()[0]);
assert($actual->equals($expected));
echo "Results of `sum`: " . $actual . PHP_EOL;

echo "Calling `sum` function (natively)...".PHP_EOL;
[$result] = $sum(3, 4);

assert($result === 7);
echo "Results of `sum`: " . $result . PHP_EOL;
