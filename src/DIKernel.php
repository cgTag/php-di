<?php
namespace cgTag\DI;

use cgTag\DI\Exceptions\DIArgumentException;

/**
 * This is used to bootstrap an application.
 *
 * There should only be one instance and it contains the root container.
 *
 * Avoid using a static reference as it makes testing difficult.
 */
final class DIKernel extends DIModule
{
    /**
     * @param IDIModule[] ...$modules
     * @throws DIArgumentException
     */
    public function __construct(...$modules)
    {
        parent::__construct(new DIContainer());

        foreach($modules as $module) {
            $this->add($module);
        }
    }
}
