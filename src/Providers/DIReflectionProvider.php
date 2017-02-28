<?php
namespace cgTag\DI\Providers;

use cgTag\DI\Bindings\DIReflectionBinding;
use cgTag\DI\IDIContainer;

/**
 * Will create instances of the class and pass options as a parameter.
 */
class DIReflectionProvider implements IDIProvider
{
    /**
     * @var DIReflectionBinding
     */
    private $binding;

    /**
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->binding = new DIReflectionBinding($className);
    }

    /**
     * Creates an instance with the passed options.
     *
     * @param IDIContainer $container
     * @return mixed
     * @internal param array $options
     */
    public function create(IDIContainer $container)
    {
        return $this->binding->resolve($container);
    }
}
