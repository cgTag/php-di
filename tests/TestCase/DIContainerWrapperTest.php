<?php
namespace cgTag\DI\Test\TestCase\DI;

use cgTag\DI\DIContainer;
use cgTag\DI\DIContainerWrapper;
use cgTag\DI\Syntax\IDIBindTo;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\Providers\MockCreator;
use cgTag\DI\Test\Mocks\Syntax\MockBindTo;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @see \cgTag\DI\DIContainerWrapper
 */
class DIContainerWrapperTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldBind()
    {
        /** @var IDIBindTo|PHPUnit_Framework_MockObject_MockObject $mock */
        $bindTo = $this->getMockBuilder(IDIBindTo::class)
            ->getMockForAbstractClass();

        /** @var DIContainer|PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMockBuilder(DIContainer::class)
            ->setMethods(['bind'])
            ->getMock();

        $mock->expects($this->once())
            ->method('bind')
            ->with('space')
            ->willReturn($bindTo);

        $mod = new DIContainerWrapper($mock);
        $this->assertSame($bindTo, $mod->bind('space'));
    }

    /**
     * @test
     */
    public function shouldCreate()
    {
        $item = new MockItem();

        /** @var DIContainer|PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMockBuilder(DIContainer::class)
            ->setMethods(['create'])
            ->getMock();

        $mock->expects($this->once())
            ->method('create')
            ->with(MockItem::class)
            ->willReturn($item);

        $mod = new DIContainerWrapper($mock);
        $this->assertSame($item, $mod->create(MockItem::class));
    }

    /**
     * @test
     */
    public function shouldGet()
    {
        /** @var DIContainer|PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMockBuilder(DIContainer::class)
            ->setMethods(['get'])
            ->getMock();

        $mock->expects($this->once())
            ->method('get')
            ->with('space')
            ->willReturn('ship');

        $mod = new DIContainerWrapper($mock);
        $this->assertEquals('ship', $mod->get('space'));
    }

    /**
     * @test
     */
    public function shouldGetContainer()
    {
        $con = $this->getNoopContainer();
        $mod = new DIContainerWrapper($con);
        $this->assertSame($con, $mod->getContainer());
    }

    /**
     * @test
     */
    public function shouldHas()
    {
        /** @var DIContainer|PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMockBuilder(DIContainer::class)
            ->setMethods(['has'])
            ->getMock();

        $mock->expects($this->once())
            ->method('has')
            ->with('space')
            ->willReturn(true);

        $mod = new DIContainerWrapper($mock);
        $this->assertTrue($mod->has('space'));
    }

    /**
     * @test
     */
    public function shouldWith()
    {
        $creator = new MockCreator();

        /** @var DIContainer|PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMockBuilder(DIContainer::class)
            ->setMethods(['with'])
            ->getMock();

        $mock->expects($this->once())
            ->method('with')
            ->with([1, 2, 3, 4])
            ->willReturn($creator);

        $mod = new DIContainerWrapper($mock);
        $this->assertSame($creator, $mod->with([1, 2, 3, 4]));
    }
}
