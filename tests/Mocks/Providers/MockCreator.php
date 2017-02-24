<?php
namespace cgTag\DI\Test\Mocks\Providers;

use cgTag\DI\IDICreator;

class MockCreator implements IDICreator
{
    /**
     * Uses a provider to create an instance.
     *
     * @param string $className
     * @return mixed
     */
    public function create(string $className)
    {
        return null;
    }
}
