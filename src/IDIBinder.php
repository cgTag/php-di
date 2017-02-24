<?php
namespace cgTag\DI;

use cgTag\DI\Syntax\IDIBindTo;

interface IDIBinder
{
    /**
     * Creates a fluid syntax for binding values to a symbol.
     *
     * @param string $symbol
     * @return IDIBindTo
     */
    public function bind(string $symbol): IDIBindTo;
}
