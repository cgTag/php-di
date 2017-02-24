<?php
namespace cgTag\DI\Test\Mocks;

class MockItem
{
    /**
     * @var array
     */
    public $options;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }
}
