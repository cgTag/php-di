<?php
namespace cgTag\DI;

interface IDIModule
{
    /**
     * This method is called by parent modules to load their binding into the container.
     *
     * @param IDIContainer $container
     */
    public function load(IDIContainer $container);
}
