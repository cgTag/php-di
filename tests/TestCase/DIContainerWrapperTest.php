<?php
namespace cgTag\DI\Test\TestCase\DI;

use cgTag\DI\DIContainer;
use cgTag\DI\DIContainerWrapper;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\Providers\MockCreator;
use cgTag\DI\Test\Mocks\Syntax\MockBindTo;
use PHPUnit\Framework\TestCase;

/**
 * @see \cgTag\DI\DIContainerWrapper
 */
class DIContainerWrapperTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBind()
    {
        $bindTo = new MockBindTo();

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
        $con = new DIContainer();
        $mod = new DIContainerWrapper($con);
        $this->assertSame($con, $mod->getContainer());
    }

    /**
     * @test
     */
    public function shouldHas()
    {
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
