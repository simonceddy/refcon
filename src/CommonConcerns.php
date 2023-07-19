<?php
namespace Eddy\RefCon;

trait CommonConcerns
{
    abstract protected function isInContainer(string $name): bool;

    abstract protected function getFromContainer(string $name): mixed;

    protected function resolveParameter(\ReflectionParameter $param)
    {
        $type = $param->getType();
        $name = $type->getName();
        if ($this->isInContainer($name)) {
            return $this->getFromContainer($name);
        }

        if (class_exists($name)
            && ($resolved = $this->create($name)) !== null
        ) {
            return $resolved;
        }

        if ($param->isDefaultValueAvailable()) {
            return $param->getDefaultValue();
        }

        return null;
    }

    protected function resolveConstructorParams(array $params)
    {
        $resolvedParams = [];

        foreach ($params as $param) {
            $resolvedParams[] = $this->resolveParameter($param);
        }

        return $resolvedParams;
    }

    public function create(string $className)
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException(
                'Could not resolve ' . $className
            );
        }

        $reflection = new \ReflectionClass($className);

        $constructor = $reflection->getConstructor();

        if (!$constructor
            || empty($params = $constructor->getParameters())
        ) {
            return new $className;
        }

        $resolvedParams = $this->resolveConstructorParams($params);
        // dd($resolvedParams);

        return $reflection->newInstanceArgs($resolvedParams);
    }
}
