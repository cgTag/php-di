<?php
namespace cgTag\DI\Test\Mocks\Syntax;

use cgTag\DI\Providers\IDIProvider;
use cgTag\DI\Syntax\IDIBindTo;

class MockBindTo implements IDIBindTo
{
    /**
     * Binds as array.
     *
     * @param array $arr
     * @return IDIBindTo
     */
    public function toArray(array $arr): IDIBindTo
    {
        return $this;
    }

    /**
     * Binds as callable.
     *
     * @param callable $value
     * @return IDIBindTo
     */
    public function toCallable(callable $value): IDIBindTo
    {
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
        return $this;
    }

    /**
     * Binds as integer.
     *
     * @param int $value
     * @return IDIBindTo
     */
    public function toInt(int $value): IDIBindTo
    {
        return $this;
    }

    /**
     * Binds as null value.
     *
     * @return IDIBindTo
     */
    public function toNull(): IDIBindTo
    {
        return $this;
    }

    /**
     * @param IDIProvider $provider
     * @return IDIBindTo
     */
    public function toProvider(IDIProvider $provider): IDIBindTo
    {
        return $this;
    }

    /**
     * Binds the class name as a service object with dependencies injected to the constructor.
     *
     * @return IDIBindTo
     */
    public function toService(): IDIBindTo
    {
        return $this;
    }

    /**
     * Binds as a singleton.
     *
     * @return IDIBindTo
     */
    public function toSingleton(): IDIBindTo
    {
        return $this;
    }

    /**
     * Binds as string.
     *
     * @param string $value
     * @return IDIBindTo
     */
    public function toString(string $value): IDIBindTo
    {
        return $this;
    }

    /**
     * Binds to a class.
     *
     * @param string $symbol
     * @return IDIBindTo
     */
    public function toSymbol(string $symbol): IDIBindTo
    {
        return $this;
    }
}
