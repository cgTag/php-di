<?php
namespace cgTag\DI\Test\TestCase\Locators;

use cgTag\DI\Bindings\IDIBinding;
use cgTag\DI\Locators\DILocatorStack;
use cgTag\DI\Locators\IDILocator;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;

class DILocatorStackTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldAddLocator()
    {
        /** @var IDILocator $loc */
        $loc = $this->getMockBuilder(IDILocator::class)->getMockForAbstractClass();

        $stack = new DILocatorStack();

        $this->assertSame($stack, $stack->add($loc));
        $this->assertCount(1, $stack->locators);
        $this->assertSame($loc, $stack->locators[0]);
    }

    /**
     * @test
     */
    public function shouldCallFind()
    {
        $stack = new DILocatorStack();

        $loc = $this->getMockBuilder(IDILocator::class)
            ->setMethods(['find'])
            ->getMockForAbstractClass();

        $loc->expects($this->once())
            ->method('find')
            ->with(MockItem::class)
            ->willReturn(null);

        $stack->add($loc);

        $this->assertNull($stack->find(MockItem::class));
    }

    /**
     * @test
     */
    public function shouldCallFindAndReturnBinding()
    {
        $stack = new DILocatorStack();

        $loc = $this->getMockBuilder(IDILocator::class)
            ->setMethods(['find'])
            ->getMockForAbstractClass();

        $item = $this->getMockBuilder(IDIBinding::class)->getMockForAbstractClass();

        $loc->expects($this->once())
            ->method('find')
            ->with(MockItem::class)
            ->willReturn($item);

        $stack->add($loc);

        $this->assertSame($item, $stack->find(MockItem::class));
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DIArgumentException
     * @expectedExceptionMessage Locator already exists
     */
    public function shouldNotAllowDuplicates()
    {
        /** @var IDILocator $loc */
        $loc = $this->getMockBuilder(IDILocator::class)->getMockForAbstractClass();

        $stack = new DILocatorStack();
        $stack->add($loc);
        $stack->add($loc);
    }

    /**
     * @test
     */
    public function shouldReturnFirstBinding()
    {
        $stack = new DILocatorStack();

        $loc = $this->getMockBuilder(IDILocator::class)
            ->setMethods(['find'])
            ->getMockForAbstractClass();

        $item = $this->getMockBuilder(IDIBinding::class)->getMockForAbstractClass();

        $loc->expects($this->once())
            ->method('find')
            ->with(MockItem::class)
            ->willReturn($item);

        $stack->add($loc);

        for ($i = 0; $i < 10; $i++) {
            $loc = $this->getMockBuilder(IDILocator::class)
                ->setMethods(['find'])
                ->getMockForAbstractClass();

            $loc->expects($this->never())->method('find');

            $stack->add($loc);
        }

        $this->assertSame($item, $stack->find(MockItem::class));
    }

    /**
     * @test
     */
    public function shouldReturnLastBinding()
    {
        $stack = new DILocatorStack();

        for ($i = 0; $i < 10; $i++) {
            $loc = $this->getMockBuilder(IDILocator::class)
                ->setMethods(['find'])
                ->getMockForAbstractClass();

            $loc->expects($this->once())
                ->method('find')
                ->with(MockItem::class)
                ->willReturn(null);

            $stack->add($loc);
        }

        $loc = $this->getMockBuilder(IDILocator::class)
            ->setMethods(['find'])
            ->getMockForAbstractClass();

        $item = $this->getMockBuilder(IDIBinding::class)->getMockForAbstractClass();

        $loc->expects($this->once())
            ->method('find')
            ->with(MockItem::class)
            ->willReturn($item);

        $stack->add($loc);

        $this->assertSame($item, $stack->find(MockItem::class));
    }

    /**
     * @test
     */
    public function shouldReturnNullIfNotFound()
    {
        $stack = new DILocatorStack();

        for ($i = 0; $i < 10; $i++) {
            $loc = $this->getMockBuilder(IDILocator::class)
                ->setMethods(['find'])
                ->getMockForAbstractClass();

            $loc->expects($this->once())
                ->method('find')
                ->with(MockItem::class)
                ->willReturn(null);

            $stack->add($loc);
        }

        $this->assertNull($stack->find(MockItem::class));
    }

    /**
     * @test
     */
    public function shouldReturnNullWhenEmpty()
    {
        $stack = new DILocatorStack();
        $this->assertNull($stack->find(MockItem::class));
    }
}