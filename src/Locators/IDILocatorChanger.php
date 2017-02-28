<?php
namespace cgTag\DI\Locators;

/**
 * Provides access to replace a locator.
 */
interface IDILocatorChanger
{
    /**
     * The current locator, or Null.
     *
     * @return IDILocator|null
     */
    public function getLocator();

    /**
     * Set the current locator, or Null to not use a locator.
     *
     * @param IDILocator|null $locator
     */
    public function setLocator(IDILocator $locator = null);

}