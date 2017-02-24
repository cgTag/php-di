<?php
namespace cgTag\DI\Bindings;

use cgTag\DI\IDIContainer;

class DIDynamicBinding implements IDIBinding
{
    /**
     * @var callable
     */
    public $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Returns the binding injectable value.
     *
     * @param IDIContainer $container
     * @return mixed
     */
    public function resolve(IDIContainer $container)
    {
        return ($this->callback)($container);
    }
}
