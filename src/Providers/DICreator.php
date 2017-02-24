<?php
namespace cgTag\DI\Providers;

use cgTag\DI\Exceptions\DIProviderException;
use cgTag\DI\IDIContainer;
use cgTag\DI\IDICreator;

final class DICreator implements IDICreator
{
    /**
     * @var IDIContainer
     */
    private $container;

    /**
     * @var array
     */
    private $options;

    /**
     * Constructor
     * @param IDIContainer $container
     * @param array $options
     */
    public function __construct(IDIContainer $container, array $options = [])
    {
        $this->container = $container;
        $this->options = $options;
    }

    /**
     * Uses a provider to create an instance.
     *
     * @param string $className
     * @return mixed
     * @throws DIProviderException
     */
    public function create(string $className)
    {
        $providerName = "{$className}Provider";
        $provider = $this->container->get($providerName);
        if (!$provider instanceof IDIProvider) {
            throw new DIProviderException(sprintf('%s is not a %s', $providerName, IDIProvider::class));
        }
        return $provider->with($this->container, $this->options);
    }
}
