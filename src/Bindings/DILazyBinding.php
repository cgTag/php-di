<?php
namespace cgTag\DI\Bindings;

use cgTag\DI\Exceptions\DINotFoundException;
use cgTag\DI\IDIContainer;

/**
 * Delays the resolving of a symbol until resolve time.
 */
class DILazyBinding implements IDIBinding
{
    /**
     * @var string
     */
    public $symbol;

    /**
     * @param string $symbol
     */
    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * Returns the binding injectable value.
     *
     * @param IDIContainer $container
     * @return mixed
     * @throws DINotFoundException
     */
    public function resolve(IDIContainer $container)
    {
        return $container->get($this->symbol);
    }
}
