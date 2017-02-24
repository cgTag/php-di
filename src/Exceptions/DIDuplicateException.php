<?php
namespace cgTag\DI\Exceptions;

class DIDuplicateException extends DIException
{
    /**
     * @param string $symbol
     */
    public function __construct(string $symbol)
    {
        parent::__construct(sprintf('Duplicate binding for: %s', $symbol), 0, null);
    }
}
