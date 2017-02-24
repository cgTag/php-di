<?php
namespace cgTag\DI\Exceptions;

class DINotFoundException extends DIException
{
    /**
     * @param string $symbol
     */
    public function __construct(string $symbol)
    {
        parent::__construct(sprintf('Injectable not found: %s', $symbol), 0, null);
    }
}
