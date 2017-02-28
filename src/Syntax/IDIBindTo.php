<?php
namespace cgTag\DI\Syntax;

use cgTag\DI\Providers\IDIProvider;

interface IDIBindTo
{
    /**
     * Binds as a singleton.
     *
     * @return IDIBindTo
     */
    public function asSingleton(): IDIBindTo;

    /**
     * Binds as array.
     *
     * @param array $arr
     * @return IDIBindTo
     */
    public function toArray(array $arr): IDIBindTo;

    /**
     * Binds as callable.
     *
     * @param callable $value
     * @return IDIBindTo
     */
    public function toCallable(callable $value): IDIBindTo;

    /**
     * Binds the current symbol to new instances of class name with dependencies injected into the constructor.
     *
     * @param string $className
     * @return IDIBindTo
     */
    public function toClass(string $className): IDIBindTo;

    /**
     * Binds to a constant value.
     *
     * @param mixed $value
     * @return IDIBindTo
     */
    public function toConstant($value): IDIBindTo;

    /**
     * Creates a binding that uses a callback to get the value.
     *
     * @param callable $callback
     * @return IDIBindTo
     */
    public function toDynamic(callable $callback): IDIBindTo;

    /**
     * Binds as float.
     *
     * @param float $value
     * @return IDIBindTo
     */
    public function toFloat(float $value): IDIBindTo;

    /**
     * Binds as integer.
     *
     * @param int $value
     * @return IDIBindTo
     */
    public function toInt(int $value): IDIBindTo;

    /**
     * Binds as null value.
     *
     * @return IDIBindTo
     */
    public function toNull(): IDIBindTo;

    /**
     * Binds as string.
     *
     * @param string $value
     * @return IDIBindTo
     */
    public function toString(string $value): IDIBindTo;

    /**
     * Binds to another symbol to that the binding acts like an alias.
     *
     * @param string $symbol
     * @return IDIBindTo
     */
    public function toSymbol(string $symbol): IDIBindTo;

    /**
     * Binds a class identifier to an instance of IDIProvider.
     *
     * @param string|IDIProvider $provider
     * @return IDIBindTo
     */
    public function withProvider($provider): IDIBindTo;
}
