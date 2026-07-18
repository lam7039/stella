<?php

namespace Stella\Core;

use Closure;
use Exception;

final class Pipeline
{
    private array $pipes = [];
    private mixed $passable;

    public function __construct(
        private readonly Container $container
    ) {}

    public function send(mixed $passable): self
    {
        $this->passable = $passable;
        return $this;
    }

    public function through(array $pipes): self
    {
        $this->pipes = $pipes;
        return $this;
    }

    public function then(Closure $destination): mixed
    {
        $pipeline = array_reduce(
            array_reverse($this->pipes),
            $this->carry(),
            $destination
        );

        return $pipeline($this->passable);
    }

    private function carry(): Closure
    {
        return function ($stack, $pipe) {
            return function ($passable) use ($stack, $pipe) {
                if ($pipe instanceof Closure) {
                    return $pipe($passable, $stack);
                }

                if (is_string($pipe)) {
                    $pipe = $this->container->get($pipe);
                }

                if (is_callable($pipe)) {
                    return $pipe($passable, $stack);
                }

                if (method_exists($pipe, 'handle')) {
                    return $this->container->call(
                        $pipe,
                        'handle',
                        [
                            'passable' => $passable,
                            'next' => $stack,
                        ]
                    );
                }

                throw new Exception('Invalid pipe');
            };
        };
    }
}
