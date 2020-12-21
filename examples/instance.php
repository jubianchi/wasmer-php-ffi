<?php

use Wasmer\{Engine, Imports, Instance, Module, Runtime, Store, Wat};

require_once __DIR__ . '/../vendor/autoload.php';

Runtime::init();
var_dump(Runtime::version());

$wat = new Wat(<<<'WAT'
(module
  (type $add_one_t (func (param i32) (result i32)))
  (func $add_one_f (type $add_one_t) (param $value i32) (result i32)
    local.get $value
    i32.const 1
    i32.add)
  (export "add_one" (func $add_one_f)))
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

$addOne = $instance->exports()->get(0)->func();

echo "Calling `add_one` function..." . PHP_EOL;
[$result] = $addOne(1);

assert($result === 2);
echo "Results of `add_one`: " . $result . PHP_EOL;
