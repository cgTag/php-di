<?php
namespace cgTag\DI;

use cgTag\DI\Bindings\IDIBinding;
use cgTag\DI\Exceptions\DIDuplicateException;

interface IDIContainer extends IDIResolver, IDIBinder
{
    /**
     * Recursively finds a binding.
     *
     * @param string $symbol
     * @return IDIBinding|null
     */
    public function getBinding(string $symbol);

    /**
     * Gets the parent of this container.
     *
     * @return IDIContainer|null
     */
    public function getParent();

    /**
     * Gets the top most container.
     *
     * @return IDIContainer
     */
    public function getRoot(): IDIContainer;

    /**
     * Is this container the root.
     *
     * @return bool
     */
    public function isRoot(): bool;

    /**
     * Creates a child container.
     *
     * @return IDIContainer
     */
    public function isolate(): IDIContainer;

    /**
     * Sets a binding in the current container.
     *
     * @param string $symbol
     * @param IDIBinding $binding
     * @param bool $overwrite
     * @return IDIContainer
     * @throws DIDuplicateException when already set and overwrite is false.
     */
    public function setBinding(string $symbol, IDIBinding $binding, bool $overwrite = false): IDIContainer;
}
