<?php
namespace cgTag\DI;

use cgTag\DI\Syntax\IDIBindTo;

/**
 * Base class for objects that want to pretend to be a container.
 */
class DIContainerWrapper implements IDIResolver, IDIBinder
{
    /**
     * @var IDIContainer
     */
    public $container;

    /**
     * @param IDIContainer $container
     */
    public function __construct(IDIContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Creates a fluid syntax for binding values to a symbol.
     *
     * @param string $symbol
     * @return IDIBindTo
     */
    public function bind(string $symbol): IDIBindTo
    {
        return $this->container->bind($symbol);
    }

    /**
     * Uses a provider to create an instance.
     *
     * @param string $className
     * @return mixed
     */
    public function create(string $className)
    {
        return $this->container->create($className);
    }

    /**
     * Gets an instance from the container.
     *
     * @param string $symbol
     * @param array $constants
     * @return mixed
     */
    public function get(string $symbol, array $constants = [])
    {
        return $this->container->get($symbol, $constants);
    }

    /**
     * Gets the container for this resolver.
     *
     * @return IDIContainer
     */
    public function getContainer(): IDIContainer
    {
        return $this->container;
    }

    /**
     * Checks if an injectable exists in this or parent containers.
     *
     * @param string $symbol
     * @return bool
     */
    public function has(string $symbol): bool
    {
        return $this->container->has($symbol);
    }

    /**
     * Defines a creator that passes arguments to the provider.
     *
     * @param array $options
     * @return IDICreator
     */
    public function with(array $options): IDICreator
    {
        return $this->container->with($options);
    }
}
