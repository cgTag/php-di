<?php
namespace cgTag\DI\Bindings;

use cgTag\DI\IDIContainer;

class DIConstantBinding implements IDIBinding
{
    /**
     * @var mixed
     */
    public $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the binding injectable value.
     *
     * @param IDIContainer $container
     * @return mixed
     */
    public function resolve(IDIContainer $container)
    {
        return $this->value;
    }
}
