<?php
namespace cgTag\DI\Containers;

use cgTag\DI\Bindings;
use cgTag\DI\Locators\IDILocator;
use cgTag\DI\Locators\IDILocatorChanger;

/**
 * Adds location support to a container, and assumes this container will be the root.
 */
class DIContainerLocator extends DIContainer implements IDILocatorChanger
{
    /**
     * @var IDILocator
     */
    private $locator;

    /**
     * @param IDILocator $locator
     */
    public function __construct(IDILocator $locator = null)
    {
        parent::__construct(null);
        $this->locator = $locator;
    }

    /**
     * Use a location service if the symbol can not be found.
     *
     * @param string $symbol
     * @return Bindings\IDIBinding|null
     */
    public function getBinding(string $symbol)
    {
        $binding = parent::getBinding($symbol);

        if ($binding !== null) {
            return $binding;
        }

        if ($this->locator === null) {
            return null;
        }

        return $this->locator->find($symbol);
    }

    /**
     * The current locator, or Null.
     *
     * @return IDILocator|null
     */
    public function getLocator()
    {
        return $this->locator;
    }

    /**
     * Set the current locator, or Null to not use a locator.
     *
     * @param IDILocator|null $locator
     */
    public function setLocator(IDILocator $locator = null)
    {
        $this->locator = $locator;
    }
}