<?php
namespace cgTag\DI\Test;

use cgTag\DI\Bindings\IDIBinding;
use cgTag\DI\DIContainer;
use cgTag\DI\IDIContainer;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

class BaseTestCase extends TestCase
{
    /**
     * A new container
     *
     * @return IDIContainer
     */
    public function getEmptyContainer(): IDIContainer
    {
        return new DIContainer(null);
    }

    /**
     * @return IDIBinding
     */
    public function getMockBinding(): IDIBinding
    {
        /** @var IDIBinding|PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMockBuilder(IDIBinding::class)
            ->getMockForAbstractClass();
        return $mock;
    }

    /**
     * A container that can not be used.
     *
     * @return IDIContainer
     */
    public function getNoopContainer(): IDIContainer
    {
        /** @var IDIContainer|PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMockBuilder(IDIContainer::class)
            ->getMockForAbstractClass();
        return $mock;
    }

    /**
     * An empty container but it can be read.
     *
     * @return IDIContainer
     */
    public function getReadOnlyContainer(): IDIContainer
    {
        /** @var IDIContainer|PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMockBuilder(DIContainer::class)
            ->setConstructorArgs(null)
            ->setMethods(['isolate', 'setBinding'])
            ->getMock();

        $mock->expects($this->never())->method('isolate');
        $mock->expects($this->never())->method('setBinding');

        return $mock;
    }

    /**
     * @param IDIContainer $parent
     * @return IDIContainer
     */
    public function getWIthParentContainer(IDIContainer $parent): IDIContainer
    {
        return new DIContainer($parent);
    }
}