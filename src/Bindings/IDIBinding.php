<?php
namespace cgTag\DI\Bindings;

use cgTag\DI\IDIContainer;

interface IDIBinding
{
    /**
     * Returns the binding injectable value.
     *
     * @param IDIContainer $container
     * @return mixed
     */
    public function resolve(IDIContainer $container);
}
