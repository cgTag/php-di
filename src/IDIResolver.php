<?php
namespace cgTag\DI;

interface IDIResolver
{
    /**
     * Gets an instance from the container.
     *
     * @param string $symbol
     * @param array $constants
     * @return mixed
     */
    public function get(string $symbol, array $constants = []);

    /**
     * Gets the container for this resolver.
     *
     * @return IDIContainer
     */
    public function getContainer(): IDIContainer;

    /**
     * Checks if an injectable exists in this or parent containers.
     *
     * @param string $symbol
     * @return bool
     */
    public function has(string $symbol): bool;
}
