<?php
namespace cgTag\DI\Test\Mocks;

class MockService
{
    /**
     * @var MockItem
     */
    public $item;

    /**
     * @param MockItem $item
     */
    public function __construct(MockItem $item)
    {
        $this->item = $item;
    }
}
