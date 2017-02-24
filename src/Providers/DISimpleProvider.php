<?php
namespace cgTag\DI\Providers;

use cgTag\DI\IDIContainer;

/**
 * Will create instances of the class and pass options as a parameter.
 */
class DISimpleProvider implements IDIProvider
{
    /**
     * @var string
     */
    private $className;

    /**
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
    }

    /**
     * Creates an instance with the passed options.
     *
     * @param IDIContainer $container
     * @param array $options
     * @return mixed
     */
    public function with(IDIContainer $container, array $options)
    {
        return new $this->className($options);
    }
}
