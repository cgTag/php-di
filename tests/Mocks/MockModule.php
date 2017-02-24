<?php
namespace cgTag\DI\Test\Mocks;

use cgTag\DI\IDIContainer;
use cgTag\DI\IDIModule;

class MockModule implements IDIModule
{
    /**
     * @var int
     */
    public $count = 0;

    /**
     * @var null|string
     */
    private $symbol;

    /**
     * @var null|string
     */
    private $value;

    /**
     * @param string|null $symbol
     * @param string|null $value
     */
    public function __construct(string $symbol = null, string $value = null)
    {
        $this->symbol = $symbol;
        $this->value = $value;
    }

    /**
     * This method is called by parent modules to load their binding into the container.
     *
     * @param IDIContainer $container
     */
    public function load(IDIContainer $container)
    {
        $this->count++;

        if ($this->symbol) {
            $container->bind($this->symbol)->toConstant($this->value);
        }
    }
}
