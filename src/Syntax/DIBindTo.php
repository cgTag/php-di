<?php
namespace cgTag\DI\Syntax;

use cgTag\DI\Bindings\DIConstantBinding;
use cgTag\DI\Bindings\DIDynamicBinding;
use cgTag\DI\Bindings\DILazyBinding;
use cgTag\DI\Bindings\DIReflectionBinding;
use cgTag\DI\Bindings\DISingletonBinding;
use cgTag\DI\Exceptions\DIArgumentException;
use cgTag\DI\Exceptions\DINotFoundException;
use cgTag\DI\IDIContainer;
use cgTag\DI\Providers\IDIProvider;

class DIBindTo implements IDIBindTo
{
    /**
     * @var IDIContainer
     */
    public $container;

    /**
     * @var string
     */
    public $symbol;

    /**
     * @param IDIContainer $container
     * @param string $symbol
     * @throws DIArgumentException
     */
    public function __construct(IDIContainer $container, string $symbol)
    {
        if (empty($symbol)) {
            throw new DIArgumentException('invalid symbol');
        }

        $this->container = $container;
        $this->symbol = $symbol;
    }

    /**
     * Binds the class name as a service object with dependencies injected to the constructor.
     *
     * @return IDIBindTo
     */
    public function asService(): IDIBindTo
    {
        $this->container->setBinding($this->symbol, new DIReflectionBinding($this->symbol));
        return $this;
    }

    /**
     * Binds as a singleton.
     *
     * @return IDIBindTo
     * @throws DINotFoundException
     */
    public function asSingleton(): IDIBindTo
    {
        $binding = $this->container->getBinding($this->symbol);
        if ($binding === null) {
            throw new DINotFoundException($this->symbol);
        }
        $this->container->setBinding($this->symbol, new DISingletonBinding($binding), true);
        return $this;
    }

    /**
     * Binds as array.
     *
     * @param array $arr
     * @return IDIBindTo
     */
    public function toArray(array $arr): IDIBindTo
    {
        return $this->toConstant($arr);
    }

    /**
     * Binds as callable.
     *
     * @param callable $value
     * @return IDIBindTo
     */
    public function toCallable(callable $value): IDIBindTo
    {
        return $this->toConstant($value);
    }

    /**
     * Binds the current symbol to new instances of class name with dependencies injected into the constructor.
     *
     * @param string $className
     * @return IDIBindTo
     */
    public function toClass(string $className): IDIBindTo
    {
        $this->container->setBinding($this->symbol, new DIReflectionBinding($className));
        return $this;
    }

    /**
     * Binds to a constant value.
     *
     * @param mixed $value
     * @return IDIBindTo
     */
    public function toConstant($value): IDIBindTo
    {
        $this->container->setBinding($this->symbol, new DIConstantBinding($value));
        return $this;
    }

    /**
     * Creates a binding that uses a callback to get the value.
     *
     * @param callable $callback
     * @return IDIBindTo
     */
    public function toDynamic(callable $callback): IDIBindTo
    {
        $this->container->setBinding($this->symbol, new DIDynamicBinding($callback));
        return $this;
    }

    /**
     * Binds as float.
     *
     * @param float $value
     * @return IDIBindTo
     */
    public function toFloat(float $value): IDIBindTo
    {
        return $this->toConstant($value);
    }

    /**
     * Binds as integer.
     *
     * @param int $value
     * @return IDIBindTo
     */
    public function toInt(int $value): IDIBindTo
    {
        return $this->toConstant($value);
    }

    /**
     * Binds as null value.
     *
     * @return IDIBindTo
     */
    public function toNull(): IDIBindTo
    {
        return $this->toConstant(null);
    }

    /**
     * Binds as string.
     *
     * @param string $value
     * @return IDIBindTo
     */
    public function toString(string $value): IDIBindTo
    {
        return $this->toConstant($value);
    }

    /**
     * Binds a symbol to another symbol for lazy resolving.
     *
     * @param string $symbol
     * @return IDIBindTo
     */
    public function toSymbol(string $symbol): IDIBindTo
    {
        $this->container->setBinding($this->symbol, new DILazyBinding($symbol));
        return $this;
    }

    /**
     * @param IDIProvider $provider
     * @return IDIBindTo
     */
    public function withProvider(IDIProvider $provider): IDIBindTo
    {
        $providerName = "{$this->symbol}Provider";
        $this->container->setBinding($providerName, new DIConstantBinding($provider));
        return $this;
    }
}
