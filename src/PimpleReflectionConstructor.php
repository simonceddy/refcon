<?php
namespace Eddy\RefCon;

use Pimple\Container;

class PimpleReflectionConstructor
{
    use CommonConcerns;

    protected Container $container;

    public function __construct(Container $container = null)
    {
        !isset($container) ?: $this->container = $container;
    }

    protected function isInContainer(string $name): bool
    {
        return isset($this->container[$name]);
    }

    protected function getFromContainer(string $name): mixed
    {
        return $this->container[$name];
    }
}