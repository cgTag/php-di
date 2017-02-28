<?php
namespace cgTag\DI\Providers;

use cgTag\DI\IDIContainer;

interface IDIProvider
{
    /**
     * Creates an instance with the passed options.
     *
     * @param IDIContainer $container
     * @return mixed
     */
    public function create(IDIContainer $container);
}
