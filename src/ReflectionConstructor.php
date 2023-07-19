<?php
namespace Eddy\RefCon;

use Psr\Container\ContainerInterface;

class ReflectionConstructor
{
    use CommonConcerns;

    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container = null)
    {
        !isset($container) ?: $this->container = $container;
    }

    protected function isInContainer(string $name): bool
    {
        return isset($this->container) && $this->container->has($name);
    }

    protected function getFromContainer(string $name): mixed
    {
        return $this->container->get($name);
    }
}