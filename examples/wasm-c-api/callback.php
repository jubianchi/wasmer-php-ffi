<?php

use Wasmer\{Engine, Imports, Instance, Module, Runtime, Store, Types, Wat};

require_once __DIR__ . '/../../vendor/autoload.php';

Runtime::init();
var_dump(Runtime::version());

$wat = new Wat(<<<'WAT'
(module
  (func $print (import "" "print") (param i32) (result i32))
  (func $closure (import "" "closure") (result i32))
  (func (export "run") (param $x i32) (param $y i32) (result i32)
    (i32.add
      (call $print (i32.add (local.get $x) (local.get $y)))
      (call $print (call $closure))
    )
  )
)
WAT);

echo "Creating engine..." . PHP_EOL;
$engine = new Engine();

echo "Creating store..." . PHP_EOL;
$store = new Store($engine);

echo "Compiling module..." . PHP_EOL;
$module = new Module($store, $wat->wasm());

unset($wat);

$i = 42;
$imports = (new Imports())
    ->namespace()
        ->func('print', Types\Func::from($store, function(int $i): int {
            echo "Calling back..." . PHP_EOL;
            var_dump($i);

            return $i;
        }))
        ->func('closure', Types\Func::from($store, function() use($i): int {
            echo "Calling back closure..." . PHP_EOL;

            return $i;
        }));

echo "Instantiating module..." . PHP_EOL;
$instance = new Instance($store, $module, $imports);

$run = $instance->exports()->get(0)->func();

echo "Calling `run` function..." . PHP_EOL;
[$result] = $run(3, 4);

//assert($result === 2);
echo "Results of `run`: " . $result . PHP_EOL;
