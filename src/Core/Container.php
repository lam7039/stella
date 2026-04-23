<?php

namespace Stella\Core;

use Stella\Core\Exceptions\ContainerException;

use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

//TODO: make container work for all functions, not just the constructor (https://chatgpt.com/c/69d2de6d-11f8-8331-b832-86d141a10e13)
class Container
{
    private array $instances = [];

    public function __construct(private array $bindings = [])
    {
        foreach ($this->bindings as $key => $concrete) {
            if (is_string($concrete) && ! class_exists($concrete)) {
                throw ContainerException::InstanceNotFound($concrete);
            }

            if (is_int($key)) {
                unset($this->bindings[$key]);
                $this->bindings[$concrete] = $concrete;
            }
        }
    }

    public function bind(string $abstract, callable|string|null $concrete = null): void
    {
        $this->bindings[$abstract] = $concrete ?? $abstract;
    }

    public function singleton(string $abstract, callable|string|null $concrete = null): void
    {
        $this->bind($abstract, $concrete);
        $this->instances[$abstract] = null;
    }

    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]);
    }

    public function get(string $abstract, array $parameters = []): object
    {
        if (
            array_key_exists($abstract, $this->instances) &&
            $this->instances[$abstract] !== null
        ) {
            return $this->instances[$abstract];
        }

        if (! $this->has($abstract)) {
            throw ContainerException::ClassNotFound($abstract);
        }

        $object = $this->resolve($this->bindings[$abstract], $parameters);

        if (array_key_exists($abstract, $this->instances)) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    public function call(object|string|array $target, ?string $method = null, array $parameters = []): mixed
    {
        if (is_array($target)) {
            [$target, $method] = $target;
        }

        if (is_string($target)) {
            $target = $this->get($target);
        }

        $reflection = new ReflectionMethod($target, $method);

        $dependencies = $this->resolveDependencies(
            $reflection->getParameters(),
            $parameters
        );

        return $target->$method(...$dependencies);
    }

    // //TODO: unused for now, vstream used it in the router class with the name get_method_params
    // public function getMethodParams(string $class, string $method): array
    // {
    //     return array_column($this->reflectedParameters($class, $method), 'name');
    // }

    // private function reflectedParameters(string $class, string $method): array
    // {
    //     if (! method_exists($class, $method)) {
    //         throw ContainerException::MethodNotFound($method);
    //     }

    //     $reflectedMethod = new ReflectionMethod($class, $method);
    //     return $reflectedMethod->getParameters();
    // }

    private function resolve(mixed $concrete, array $parameters): object
    {
        if (is_callable($concrete)) {
            return $concrete($this, $parameters);
        }

        $reflection = new ReflectionClass($concrete);
        if (! $reflection->isInstantiable()) {
            throw ContainerException::InvalidInstance($concrete);
        }

        $constructor = $reflection->getConstructor();
        if (! $constructor) {
            return new $concrete;
        }

        $dependencies = $this->resolveDependencies(
            $constructor->getParameters(),
            $parameters
        );
        
        return new $concrete(...$dependencies);
    }

    private function resolveDependencies(array $parameters, array $provided): array
    {
        return array_map(
            fn (ReflectionParameter $parameter) => $this->resolveParameter($parameter, $provided),
            $parameters 
        );
    }

    private function resolveParameter(ReflectionParameter $parameter, array $provided): mixed
    {
        $name = $parameter->getName();
        $type = $parameter->getType();
        $class = $parameter->getDeclaringClass()?->name ?? 'unknown';

        if (array_key_exists($name, $provided)) {
            return $provided[$name];
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        return match (true) {
            $type instanceof ReflectionNamedType => $this->resolveNamedType($type, $name, $provided),
            $type instanceof ReflectionUnionType => $this->resolveUnionType($type, $name, $provided),
            // $type instanceof ReflectionIntersectionType => $this->resolveIntersectionType($type, $name, $provided),
            $type instanceof ReflectionIntersectionType => throw ContainerException::InvalidIntersection($class, $name),
            default => throw ContainerException::InvalidParameter($class, $name),
        };
    }

    private function resolveNamedType(ReflectionNamedType $type, string $name, array $parameters): mixed
    {
        if ($type->isBuiltin() && array_key_exists($name, $parameters)) {
            return $parameters[$name];
        }

        if (! $type->isBuiltin()) {
            return $this->get($type->getName(), $parameters);
        }

        throw ContainerException::ParameterNotFound($name);
    }

    private function resolveUnionType(ReflectionUnionType $union, string $name, array $parameters): mixed
    {
        foreach ($union->getTypes() as $type) {
            try {
                return $this->resolveNamedType($type, $name, $parameters);
            } catch (\Throwable) {
                continue;
            }
        }

        throw ContainerException::ParameterNotFound($name);
    }

    // //TODO: test intersection resolve
    // private function resolveIntersectionType(ReflectionIntersectionType $intersection, string $name, array $parameters): mixed
    // {
    //     if (array_key_exists($name, $parameters)) {
    //         return $parameters[$name];
    //     }

    //     $types = $intersection->getTypes();

    //     foreach ($this->bindings as $abstract => $concrete) {
    //         if (! is_string($concrete) || ! class_exists($concrete)) {
    //             continue;
    //         }

    //         $reflection = new ReflectionClass($concrete);
            
    //         foreach ($types as $type) {
    //             $typeName = $type->getName();

    //             if ($type->isBuiltin()) {
    //                 continue 2;
    //             }

    //             if (
    //                 ! $reflection->implementsInterface($typeName) &&
    //                 ! $reflection->isSubclassOf($typeName) &&
    //                 $reflection->getName() !== $typeName
    //             ) {
    //                 continue 2;
    //             }
    //         }
                
    //         return $this->get($abstract, $parameters);
    //     }

    //     throw ContainerException::ParameterNotFound($name);
    // }
}
