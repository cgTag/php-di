<?php
namespace cgTag\DI\Bindings;

use cgTag\DI\Exceptions\DIArgumentException;
use cgTag\DI\Exceptions\DINotFoundException;
use cgTag\DI\Exceptions\DIReflectionException;
use cgTag\DI\IDIContainer;

class DIReflectionBinding implements IDIBinding
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var array
     */
    private $symbols;

    /**
     * @var \ReflectionClass
     */
    private $reflectClass;

    /**
     * @param IDIContainer $container
     * @param string $className
     * @param array $symbols
     * @return array
     * @throws DIReflectionException
     */
    public static function getResolved(IDIContainer $container, string $className, array $symbols): array
    {
        $values = [];
        $failure = false;
        foreach ($symbols as &$symbol) {
            try {
                $values[] = $container->get($symbol);
            } catch (DINotFoundException $ex) {
                $symbol .= '?';
                $failure = true;
            }
        }

        if ($failure) {
            throw new DIReflectionException(sprintf('new %s(%s)', $className, implode(', ', $symbols)));
        }

        return $values;
    }

    /**
     * Generates the name of a method parameter but resolving first the parameter type, and if it's a built in
     * type the parameter name is used (i.e. string, int, array).
     *
     * @param \ReflectionParameter $param
     * @return string
     */
    public static function getSymbol(\ReflectionParameter $param): string
    {
        $type = $param->getType();

        return $type !== null && !$type->isBuiltin()
            ? (string)$type
            : $param->getName();
    }

    /**
     * Gets the symbols of injectables for the constructor.
     *
     * @param \ReflectionFunctionAbstract $method
     * @return array
     */
    public static function getSymbols(\ReflectionFunctionAbstract $method): array
    {
        return array_map(function (\ReflectionParameter $param) {
            return static::getSymbol($param);
        }, $method->getParameters());
    }

    /**
     * @param string $className
     * @throws DIArgumentException
     */
    public function __construct(string $className)
    {
        if (empty($className)) {
            throw new DIArgumentException('invalid className');
        }

        $this->className = $className;
    }

    /**
     * @return \ReflectionClass
     */
    public function getClass(): \ReflectionClass
    {
        return new \ReflectionClass($this->className);
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * Returns the binding injectable value.
     *
     * @param IDIContainer $container
     * @return mixed
     */
    public function resolve(IDIContainer $container)
    {
        if(!$this->symbols) {
            $this->symbols = static::getSymbols($this->getClass()->getConstructor());
        }

        if(!$this->reflectClass) {
            $this->reflectClass = $this->getClass();
        }

        $values = static::getResolved($container, $this->className, $this->symbols);

        return $this->reflectClass->newInstanceArgs($values);
    }
}
