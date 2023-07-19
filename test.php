<?php
require 'vendor/autoload.php';

class TestClass1
{}

class TestClass2
{
    public function __construct(
        private TestClass1 $testClass1
    ) {}
}

$pimple = new \Pimple\Container();
$pimple[TestClass1::class] = function () {
    return new TestClass1();
};

$psr = new \Pimple\Psr11\Container($pimple);

var_dump(
    (new \Eddy\RefCon\PimpleReflectionConstructor($pimple))
        ->create(TestClass2::class) instanceof TestClass2
);
var_dump(
    (new \Eddy\RefCon\ReflectionConstructor($psr))
        ->create(TestClass2::class) instanceof TestClass2
);
