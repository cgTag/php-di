<?php
namespace cgTag\DI\Test\Mocks;

use cgTag\DI\IDIContainer;
use cgTag\DI\Providers\IDIProvider;

class MockItemProvider implements IDIProvider
{
    /**
     * Creates an instance with the passed options.
     *
     * @param IDIContainer $container
     * @param array $options
     * @return mixed
     */
    public function with(IDIContainer $container, array $options)
    {
        return new MockItem($options);
    }
}
