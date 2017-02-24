<?php
namespace cgTag\DI\Locations;

use cgTag\DI\Bindings\IDIBinding;
use cgTag\DI\Exceptions\DIArgumentException;

class DILocatorStack implements IDILocator
{
    /**
     * @var IDILocator[]
     */
    public $locators = [];

    /**
     * Adds a child locator.
     *
     * @param IDILocator $locator
     * @return DILocatorStack
     * @throws DIArgumentException
     */
    public function add(IDILocator $locator): DILocatorStack
    {
        if (in_array($locator, $this->locators)) {
            throw new DIArgumentException('Locator already exists');
        }

        $this->locators[] = $locator;
        return $this;
    }

    /**
     * Searches the application space for a symbol and returns a binding if successful, or null if not found.
     *
     * @param string $symbol
     * @return IDIBinding|null
     */
    public function find(string $symbol)
    {
        foreach ($this->locators as $locator) {
            $binding = $locator->find($symbol);
            if ($binding !== null) {
                return $binding;
            }
        }
        return null;
    }
}
