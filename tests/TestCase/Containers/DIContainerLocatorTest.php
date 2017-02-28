<?php
namespace cgTag\DI\Test\TestCase\Containers;

use cgTag\DI\Bindings\IDIBinding;
use cgTag\DI\Containers\DIContainerLocator;
use cgTag\DI\Locators\IDILocator;
use cgTag\DI\Test\BaseTestCase;

class DIContainerLocatorTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldCallLocatorFind()
    {
        $binding = $this->getMockBuilder(IDIBinding::class)
            ->getMockForAbstractClass();

        $mock = $this->getMockBuilder(IDILocator::class)
            ->getMockForAbstractClass();

        $mock->expects($this->once())
            ->method('find')
            ->with('FooBar')
            ->willReturn($binding);

        $con = new DIContainerLocator($mock);
        $this->assertSame($binding, $con->getBinding('FooBar'));
    }

    /**
     * @test
     */
    public function shouldChangeLocator()
    {
        $con = new DIContainerLocator();

        $mock = $this->getMockBuilder(IDILocator::class)
            ->getMockForAbstractClass();

        $con->setLocator($mock);
        $this->assertSame($mock, $con->getLocator());
    }

    /**
     * @test
     */
    public function shouldConstructorSetLocator()
    {
        $mock = $this->getMockBuilder(IDILocator::class)
            ->getMockForAbstractClass();

        $con = new DIContainerLocator($mock);

        $this->assertSame($mock, $con->getLocator());
    }

    /**
     * @test
     */
    public function shouldDefaultToNullLocator()
    {
        $con = new DIContainerLocator();
        $this->assertNull($con->getLocator());
    }
}