<?php
namespace cgTag\DI\Syntax;

use cgTag\DI\Providers\IDIProvider;

interface IDIBindTo
{
    /**
     * Binds the class name as a service object with dependencies injected to the constructor.
     *
     * @return IDIBindTo
     */
    public function toService(): IDIBindTo;

    /**
     * Binds as a singleton.
     *
     * @return IDIBindTo
     */
    public function toSingleton(): IDIBindTo;

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
     * Binds to a class.
     *
     * @param string $symbol
     * @return IDIBindTo
     */
    public function toSymbol(string $symbol): IDIBindTo;

    /**
     * @param IDIProvider $provider
     * @return IDIBindTo
     */
    public function toProvider(IDIProvider $provider): IDIBindTo;
}
