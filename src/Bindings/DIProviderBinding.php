<?php
namespace cgTag\DI\Bindings;

use cgTag\DI\Exceptions\DIArgumentException;
use cgTag\DI\IDIContainer;
use cgTag\DI\Providers\IDIProvider;

class DIProviderBinding implements IDIBinding
{
    /**
     * @var IDIProvider|string
     */
    public $provider;

    /**
     * @param string|IDIProvider $provider
     * @throws DIArgumentException
     */
    public function __construct($provider)
    {
        if (!is_string($provider) && !$provider instanceof IDIProvider) {
            throw new DIArgumentException('Provider of wrong type');
        }
        $this->provider = $provider;
    }

    /**
     * Returns the binding injectable value.
     *
     * @param IDIContainer $container
     * @return mixed
     */
    public function resolve(IDIContainer $container)
    {
        /** @var IDIProvider $provider */
        $provider = is_string($this->provider)
            ? $container->get($this->provider)
            : $this->provider;

        return $provider->create($container);
    }
}