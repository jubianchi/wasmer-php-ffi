<?php

use Wasmer\{Engine, Imports, Instance, Module, Runtime, Store, Types, Types\Val, Wat};

require_once __DIR__ . '/../vendor/autoload.php';

Runtime::init();
var_dump(Runtime::version());

$wat = new Wat(<<<'WAT'
(module
  (func $host_function (import "" "host_function"))
  (global $host_global (import "env" "host_global") i32)

  (func $function (export "guest_function") (result i32) (global.get $global))
  (global $global (export "guest_global") i32 (i32.const 42))
  (table $table (export "guest_table") 1 1 funcref)
  (memory $memory (export "guest_memory") 1))
WAT);

echo "Creating engine..." . PHP_EOL;
$engine = new Engine();

echo "Creating store..." . PHP_EOL;
$store = new Store($engine);

echo "Compiling module..." . PHP_EOL;
$module = new Module($store, $wat->wasm());

unset($wat);

echo "Creating the imported function..." . PHP_EOL;
$hostFunction = Types\Func::from($store, function() {});

echo "Creating the imported global..." . PHP_EOL;
$hostGlobal = Types\Glob::new(
    $store,
    Types\GlobalType::new(
        Types\ValType::new(Types\Kind\Val::I32()),
        Types\Mutability::CONST()
    ),
    Val::new(
        Types\Kind\Val::I32(),
        42
    )
);

$imports = new Imports();
$imports
    ->namespace()
        ->func('host_function', $hostFunction)
    ->namespace('env')
        ->global('host_global', $hostGlobal)
;

echo "Instantiating module..." . PHP_EOL;
$instance = new Instance($store, $module, $imports);

echo "Getting the exported function..." . PHP_EOL;
$guestFunction = $instance->exports()->get(0)->func();

printf("Got the exported function: %s" . PHP_EOL, $guestFunction);

echo "Getting the exported global..." . PHP_EOL;
$guestGlobal = $instance->exports()->get(1)->global();

printf("Got the exported global: %s" . PHP_EOL, $guestGlobal);
var_dump($guestGlobal);

echo "Getting the exported memory...".PHP_EOL;
$guestMemory = $instance->exports()->get(3)->memory();

printf("Got the exported memory: %s" . PHP_EOL, $guestMemory);
var_dump($guestMemory);

// TODO(jubianchi): Implement Table
