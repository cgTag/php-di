<?php
namespace cgTag\DI;

interface IDICreator
{
    /**
     * Uses a provider to create an instance.
     *
     * @param string $className
     * @return mixed
     */
    public function create(string $className);
}
