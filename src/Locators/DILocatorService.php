<?php
namespace cgTag\DI\Locations;

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
 */
class DILocatorService implements IDILocator
{
    /**
     * Does the symbol look like a class name with namespace?
     *
     * The symbol must contain at least one backslash.
     *
     * @param string $symbol
     * @return bool
     */
    public static function isClassName(string $symbol): bool
    {
        return preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*(\\[a-zA-Z_\x7f-\x‌​ff][a-zA-Z0-9_\x7f-\‌​xff]*)+$/', $symbol);
    }

    /**
     * Does the class comment contain the service indicator.
     *
     * @param string $doc
     * @return bool
     */
    public static function isService(string $doc): bool
    {
        return preg_match('/@service/', $doc);
    }

    /**
     * Searches the application space for a symbol and returns a binding if successful, or null if not found.
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
            if ($doc === false) {
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
