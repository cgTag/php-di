<?php
namespace cgTag\DI\Locators;

use cgTag\DI\Bindings\DIReflectionBinding;
use cgTag\DI\Bindings\IDIBinding;

/**
 * Uses reflection to auto-bind to classes annotated as services.
 *
 * # Example
 *
 * ```
 * @service [<description>]
 * ```
 *
 * @see \cgTag\DI\Test\TestCase\Locators\DILocatorServiceTest
 */
class DILocatorService implements IDILocator
{
    /**
     * Regex for part of a class name.
     */
    const IDENTIFIER = '([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)';

    /**
     * Does the symbol look like a class name with namespace?
     *
     * The symbol must contain at least one level of namespace.
     *
     * @param string $symbol
     * @return bool
     */
    public static function isClassName(string $symbol): bool
    {
        static $regex = null;
        if ($regex === null) {
            $regex = sprintf('/^%1$s(\\\\%1$s)+$/', static::IDENTIFIER);
        }
        return preg_match($regex, $symbol);
    }

    /**
     * Does the class comment contain the service indicator.
     *
     * @param string $doc
     * @return bool
     */
    public static function isService(string $doc = null): bool
    {
        if($doc === null || $doc === '') {
            return false;
        }
        // very broad match but should be okay for now.
        return preg_match('/\\*\s*@service\b/m', $doc);
    }

    /**
     * If the symbol is a class name, then reflection is used to see if it is annotated as a service.
     *
     * @param string $symbol
     * @return IDIBinding|null
     */
    public function find(string $symbol)
    {
        if (!static::isClassName($symbol)) {
            return null;
        }

        try {
            $class = new \ReflectionClass($symbol);
            if (!$class->isInstantiable()) {
                return null;
            }
            $doc = $class->getDocComment();
            if ($doc === false || empty($doc)) {
                return null;
            }
            if (!static::isService($doc)) {
                return null;
            }

            return new DIReflectionBinding($symbol);
        } catch (\ReflectionException $ex) {
            return null;
        }
    }
}
