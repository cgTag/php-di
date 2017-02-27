<?php
namespace cgTag\DI\Locators;

use cgTag\DI\Bindings\IDIBinding;

interface IDILocator
{
    /**
     * Searches the application space for a symbol and returns a binding if successful, or null if not found.
     *
     * @param string $symbol
     * @return IDIBinding|null
     */
    public function find(string $symbol);
}
