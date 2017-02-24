<?php
namespace cgTag\DI\Test\Mocks;

use cgTag\DI\DIModule;
use cgTag\DI\IDIContainer;

/**
 * Tests the base constructor
 */
class MockModuleLoad extends DIModule
{
    /**
     * @var int
     */
    public $count = 0;

    /**
     * @param IDIContainer $container
     */
    public function load(IDIContainer $container)
    {
        $this->count++;
    }
}
