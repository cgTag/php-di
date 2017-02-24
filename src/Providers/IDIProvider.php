<?php
namespace cgTag\DI\Providers;

use cgTag\DI\IDIContainer;

interface IDIProvider
{
    /**
     * Creates an instance with the passed options.
     *
     * @param IDIContainer $container
     * @param array $options
     * @return mixed
     */
    public function with(IDIContainer $container, array $options);
}
