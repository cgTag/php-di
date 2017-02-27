<?php
namespace cgTag\DI;

use cgTag\DI\Exceptions\DIArgumentException;

/**
 * Base class for application modules that allows for loading of other modules. If you don't need to load additional
 * modules, then you can just implement the interface.
 */
class DIModule extends DIContainerWrapper implements IDIModule
{
    /**
     * @param IDIContainer $container
     */
    public function __construct(IDIContainer $container)
    {
        parent::__construct($container);
        $this->load($container);
    }

    /**
     * Loads additional modules.
     *
     * @param array ...$modules
     * @throws DIArgumentException
     */
    public function add(...$modules)
    {
        array_walk_recursive($modules, function ($module) {
            if (!$module instanceof IDIModule) {
                throw new DIArgumentException('not a module');
            }
            $module->load($this->container);
        });
    }

    /**
     * This method is called by parent modules to load their binding into the container.
     *
     * @param IDIContainer $container
     */
    public function load(IDIContainer $container)
    {
    }
}
