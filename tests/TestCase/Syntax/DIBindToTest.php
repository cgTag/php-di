<?php
namespace cgTag\DI\Test\TestCase\DI\Syntax;

use cgTag\DI\Bindings\DIConstantBinding;
use cgTag\DI\Bindings\DIDynamicBinding;
use cgTag\DI\Bindings\DILazyBinding;
use cgTag\DI\Bindings\DIProviderBinding;
use cgTag\DI\Bindings\DISingletonBinding;
use cgTag\DI\Syntax\DIBindTo;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\MockItemProvider;

/**
 * @see \cgTag\DI\Syntax\DIBindTo
 */
class DIBindToTest extends BaseTestCase
{
    /**
     * Replaces the binding with a singleton binding that wraps the previous binding.
     *
     * @test
     */
    public function shouldAsSingleton()
    {
        $con = $this->getEmptyContainer();
        $con->bind('space')->toConstant(1);

        $to = new DIBindTo($con, 'space');
        $to->asSingleton();
        $this->assertInstanceOf(DISingletonBinding::class, $con->getBinding('space'));
        $this->assertEquals(1, $con->getBinding('space')->resolve($con));
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DINotFoundException
     * @expectedExceptionMessage Injectable not found: space
     */
    public function shouldAsSingletonThrowNotFound()
    {
        $con = $this->getEmptyContainer();
        $to = new DIBindTo($con, 'space');
        $to->asSingleton();
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DIArgumentException
     * @expectedExceptionMessage invalid symbol
     */
    public function shouldThrowOnEmptySymbol()
    {
        $con = $this->getEmptyContainer();
        new DIBindTo($con, '');
    }

    /**
     * @test
     */
    public function shouldToArray()
    {
        $con = $this->getEmptyContainer();
        $to = new DIBindTo($con, 'space');
        $to->toArray([1, 2, 3, 4]);
        $this->assertInstanceOf(DIConstantBinding::class, $con->getBinding('space'));
        $this->assertSame([1, 2, 3, 4], $con->getBinding('space')->resolve($con));
    }

    /**
     * Allows closures to be injectable.
     *
     * @test
     */
    public function shouldToCallable()
    {
        $closure = function () {
            // my closure to inject
        };

        $con = $this->getEmptyContainer();
        $to = new DIBindTo($con, 'space');
        $to->toCallable($closure);
        $this->assertInstanceOf(DIConstantBinding::class, $con->getBinding('space'));
        $this->assertSame($closure, $con->getBinding('space')->resolve($con));
    }

    /**
     * @test
     */
    public function shouldToConstant()
    {
        $con = $this->getEmptyContainer();
        $to = new DIBindTo($con, 'space');
        $to->toConstant('hello');
        $this->assertInstanceOf(DIConstantBinding::class, $con->getBinding('space'));
        $this->assertSame('hello', $con->getBinding('space')->resolve($con));
    }

    /**
     * @test
     */
    public function shouldToDynamic()
    {
        $con = $this->getEmptyContainer();
        $to = new DIBindTo($con, 'space');
        $to->toDynamic(function () {
            return 'ship';
        });
        $this->assertInstanceOf(DIDynamicBinding::class, $con->getBinding('space'));
        $this->assertSame('ship', $con->getBinding('space')->resolve($con));
    }

    /**
     * @test
     */
    public function shouldToFloat()
    {
        $con = $this->getEmptyContainer();
        $to = new DIBindTo($con, 'space');
        $to->toFloat(1.234);
        $this->assertInstanceOf(DIConstantBinding::class, $con->getBinding('space'));
        $this->assertSame(1.234, $con->getBinding('space')->resolve($con));
    }

    /**
     * @test
     */
    public function shouldToInt()
    {
        $con = $this->getEmptyContainer();
        $to = new DIBindTo($con, 'space');
        $to->toInt(234);
        $this->assertInstanceOf(DIConstantBinding::class, $con->getBinding('space'));
        $this->assertSame(234, $con->getBinding('space')->resolve($con));
    }

    /**
     * @test
     */
    public function shouldToNull()
    {
        $con = $this->getEmptyContainer();
        $to = new DIBindTo($con, 'space');
        $to->toNull();
        $this->assertInstanceOf(DIConstantBinding::class, $con->getBinding('space'));
        $this->assertNull($con->getBinding('space')->resolve($con));
    }

    /**
     * @test
     */
    public function shouldToString()
    {
        $con = $this->getEmptyContainer();
        $to = new DIBindTo($con, 'space');
        $to->toString('hello');
        $this->assertInstanceOf(DIConstantBinding::class, $con->getBinding('space'));
        $this->assertSame('hello', $con->getBinding('space')->resolve($con));
    }

    /**
     * @test
     */
    public function shouldToSymbol()
    {
        $con = $this->getEmptyContainer();
        $con->bind('ship')->toConstant(1234);
        $to = new DIBindTo($con, 'space');
        $to->toSymbol('ship');
        $this->assertInstanceOf(DILazyBinding::class, $con->getBinding('space'));
        $this->assertSame(1234, $con->getBinding('space')->resolve($con));
    }

    /**
     * @test
     */
    public function shouldWithProvider()
    {
        $class = MockItem::class;
        $provider = new MockItemProvider();

        $con = $this->getEmptyContainer();
        $con->bind($class)->withProvider($provider);

        $this->assertInstanceOf(DIProviderBinding::class, $con->getBinding(MockItem::class));

        $item1 = $con->get(MockItem::class, ['options' => [1]]);
        $item2 = $con->get(MockItem::class, ['options' => [2]]);
        $item3 = $con->get(MockItem::class, ['options' => [3]]);

        $this->assertInstanceOf(MockItem::class, $item1);
        $this->assertEquals([1], $item1->options);

        $this->assertInstanceOf(MockItem::class, $item2);
        $this->assertEquals([2], $item2->options);

        $this->assertInstanceOf(MockItem::class, $item3);
        $this->assertEquals([3], $item3->options);
    }

    /**
     * @test
     */
    public function shouldWithProviderAndSingleton()
    {
        $class = MockItem::class;
        $provider = new MockItemProvider();

        $con = $this->getEmptyContainer();
        $con->bind($class)->withProvider($provider)->asSingleton();

        $this->assertInstanceOf(DISingletonBinding::class, $con->getBinding(MockItem::class));

        $item1 = $con->get(MockItem::class, ['options' => [1]]);
        $item2 = $con->get(MockItem::class, ['options' => [2]]);
        $item3 = $con->get(MockItem::class, ['options' => [3]]);

        $this->assertInstanceOf(MockItem::class, $item1);
        $this->assertEquals([1], $item1->options);
        $this->assertInstanceOf(MockItem::class, $item2);
        $this->assertEquals([1], $item2->options);
        $this->assertInstanceOf(MockItem::class, $item3);
        $this->assertEquals([1], $item3->options);

        $this->assertSame($item1, $item2);
        $this->assertSame($item1, $item3);
    }
}
