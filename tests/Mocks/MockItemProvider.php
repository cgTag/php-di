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
     * @return mixed
     * @internal param array $options
     */
    public function create(IDIContainer $container)
    {
        return new MockItem($container->get('options'));
    }
}
