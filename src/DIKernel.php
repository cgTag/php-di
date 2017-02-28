<?php
namespace cgTag\DI;

use cgTag\DI\Containers\DIContainerLocator;
use cgTag\DI\Exceptions\DIArgumentException;
use cgTag\DI\Locators\IDILocator;
use cgTag\DI\Locators\IDILocatorChanger;

/**
 * This is used to bootstrap an application.
 *
 * There should only be one instance and it contains the root container.
 *
 * Avoid using a static reference as it makes testing difficult.
 */
final class DIKernel extends DIModule implements IDILocatorChanger
{
    /**
     * @param IDIModule[] ...$modules
     * @throws DIArgumentException
     */
    public function __construct(...$modules)
    {
        parent::__construct(new DIContainerLocator());

        foreach ($modules as $module) {
            $this->add($module);
        }
    }

    /**
     * The current locator, or Null.
     *
     * @return IDILocator|null
     */
    public function getLocator()
    {
        /** @var DIContainerLocator $con */
        $con = $this->container;
        return $con->getLocator();
    }

    /**
     * Gets the top most container.
     *
     * @return IDIContainer
     */
    public function getRoot(): IDIContainer
    {
        return $this->getContainer()->getRoot();
    }

    /**
     * Set the current locator, or Null to not use a locator.
     *
     * @param IDILocator|null $locator
     */
    public function setLocator(IDILocator $locator = null)
    {
        /** @var DIContainerLocator $con */
        $con = $this->container;
        $con->setLocator($locator);
    }
}
