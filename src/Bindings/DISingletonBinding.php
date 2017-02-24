<?php
namespace cgTag\DI\Bindings;

use cgTag\DI\IDIContainer;

class DISingletonBinding implements IDIBinding
{
    /**
     * @var IDIBinding
     */
    public $inner;

    /**
     * @var bool
     */
    public $resolved = false;

    /**
     * @var mixed
     */
    public $singleton;

    /**
     * @param IDIBinding $inner
     */
    public function __construct(IDIBinding $inner)
    {
        $this->inner = $inner;
    }

    /**
     * Returns the binding injectable value.
     *
     * @param IDIContainer $container
     * @return mixed
     */
    public function resolve(IDIContainer $container)
    {
        if ($this->resolved === false) {
            $this->singleton = $this->inner->resolve($container);
            $this->resolved = true;
        }
        return $this->singleton;
    }
}
