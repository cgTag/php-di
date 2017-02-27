<?php
namespace cgTag\DI\Test\TestCase\DI\Syntax;

use cgTag\DI\Bindings\DIConstantBinding;
use cgTag\DI\Bindings\DIDynamicBinding;
use cgTag\DI\Bindings\DILazyBinding;
use cgTag\DI\Bindings\DIReflectionBinding;
use cgTag\DI\Bindings\DISingletonBinding;
use cgTag\DI\DIContainer;
use cgTag\DI\Syntax\DIBindTo;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\MockItemProvider;
use cgTag\DI\Test\Mocks\MockService;

/**
 * @see \cgTag\DI\Syntax\DIBindTo
 */
class DIBindToTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldAsService()
    {
        $item = new MockItem();
        $con = $this->getEmptyContainer();
        $con->bind(MockItem::class)->toConstant($item);

        $to = new DIBindTo($con, MockService::class);
        $to->asService();

        $this->assertInstanceOf(DIReflectionBinding::class, $con->getBinding(MockService::class));

        /** @var MockService $service */
        $service = $con->get(MockService::class);

        $this->assertInstanceOf(MockService::class, $service);
        $this->assertInstanceOf(MockItem::class, $service->item);
    }

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

        $providerName = "{$class}Provider";
        $this->assertTrue($con->has($providerName));
        $this->assertInstanceOf(DIConstantBinding::class, $con->getBinding($providerName));
        $this->assertSame($provider, $con->get($providerName));
    }
}
