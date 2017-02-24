<?php
namespace cgTag\DI;

use cgTag\DI\Bindings\DIConstantBinding;
use cgTag\DI\Bindings\IDIBinding;
use cgTag\DI\Exceptions\DIArgumentException;
use cgTag\DI\Exceptions\DIDuplicateException;
use cgTag\DI\Exceptions\DINotFoundException;
use cgTag\DI\Exceptions\DIProviderException;
use cgTag\DI\Providers\DICreator;
use cgTag\DI\Providers\IDIProvider;
use cgTag\DI\Syntax\DIBindTo;
use cgTag\DI\Syntax\IDIBindTo;

class DIContainer implements IDIContainer
{
    /**
     * Cache of resolved symbols.
     *
     * @var array
     */
    private $bindings;

    /**
     * @var IDICreator
     */
    private $creator;

    /**
     * Owner of this container.
     *
     * @var DIContainer|null
     */
    private $parent;

    /**
     * @param IDIContainer|null $parent
     */
    public function __construct(IDIContainer $parent = null)
    {
        $this->parent = $parent;
        $this->bindings = [];
        $this->creator = new DICreator($this, []);
        $this->setBinding(IDIContainer::class, new DIConstantBinding($this));
    }

    /**
     * Creates a fluid syntax for binding values to a symbol.
     *
     * @param string $symbol
     * @return IDIBindTo
     */
    public function bind(string $symbol): IDIBindTo
    {
        return new DIBindTo($this, $symbol);
    }

    /**
     * Uses a provider to create an instance.
     *
     * @param string $className
     * @return IDIProvider
     * @throws DIProviderException
     */
    public function create(string $className)
    {
        return $this->creator->create($className);
    }

    /**
     * Gets an instance from the container.
     *
     * @param string $symbol
     * @param array $constants
     * @return mixed
     * @throws DIArgumentException
     * @throws DINotFoundException
     */
    public function get(string $symbol, array $constants = [])
    {
        /** @var DIContainer $container */
        $container = count($constants)
            ? $this->isolate()
            : $this;

        if (count($constants)) {
            foreach ($constants as $key => $value) {
                if (is_numeric($key)) {
                    throw new DIArgumentException('invalid symbol for constant');
                }
                $container->bind($key)->toConstant($value);
            }
        }

        $binding = $container->getBinding($symbol);
        if ($binding === null) {
            throw new DINotFoundException($symbol);
        }

        return $binding->resolve($container);
    }

    /**
     * Recursively finds a binding.
     *
     * @param string $symbol
     * @return IDIBinding
     */
    public function getBinding(string $symbol)
    {
        $binding = array_key_exists($symbol, $this->bindings)
            ? $this->bindings[$symbol]
            : null;
        if ($binding) {
            return $binding;
        }
        return $this->parent !== null
            ? $this->parent->getBinding($symbol)
            : null;
    }

    /**
     * Gets the container for this resolver.
     *
     * @return IDIContainer
     */
    public function getContainer(): IDIContainer
    {
        return $this;
    }

    /**
     * Gets the parent of this container.
     *
     * @return IDIContainer|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Gets the top most container.
     *
     * @return IDIContainer
     */
    public function getRoot(): IDIContainer
    {
        return $this->parent === null
            ? $this
            : $this->parent->getRoot();
    }

    /**
     * Checks if an injectable exists in this or parent containers.
     *
     * @param string $symbol
     * @return bool
     */
    public function has(string $symbol): bool
    {
        if (array_key_exists($symbol, $this->bindings)) {
            return true;
        }
        return $this->parent !== null
            ? $this->parent->has($symbol)
            : false;
    }

    /**
     * Is this container the root.
     *
     * @return bool
     */
    public function isRoot(): bool
    {
        return $this->parent === null;
    }

    /**
     * Creates a child container.
     *
     * @return IDIContainer
     */
    public function isolate(): IDIContainer
    {
        return new DIContainer($this);
    }

    /**
     * Assigns a binding to a symbol.
     *
     * @param string $symbol
     * @param IDIBinding $binding
     * @param bool $replace
     * @return IDIContainer
     * @throws DIDuplicateException
     */
    public function setBinding(string $symbol, IDIBinding $binding, bool $replace = false): IDIContainer
    {
        if (!$replace && array_key_exists($symbol, $this->bindings)) {
            throw new DIDuplicateException($symbol);
        }
        $this->bindings[$symbol] = $binding;
        return $this;
    }

    /**
     * Defines a creator that passes arguments to the provider.
     *
     * @param array $options
     * @return IDICreator
     */
    public function with(array $options): IDICreator
    {
        return new DICreator($this, $options);
    }
}
