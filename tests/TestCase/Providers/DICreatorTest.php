<?php
namespace cgTag\DI\Test\TestCase\DI\Providers;

use cgTag\DI\DIContainer;
use cgTag\DI\Providers\DICreator;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\MockItemProvider;
use PHPUnit\Framework\TestCase;

/**
 * @see \cgTag\DI\Providers\DICreator
 */
class DICreatorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreate()
    {
        $con = new DIContainer();
        $con->bind(MockItem::class)->withProvider(new MockItemProvider());

        $creator = new DICreator($con);
        $item = $creator->create(MockItem::class);

        $this->assertInstanceOf(MockItem::class, $item);
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DINotFoundException
     * @expectedExceptionMessage Injectable not found: cgTag\DI\Test\Mocks\MockItemProvider
     */
    public function shouldFailWhenProviderNotFound()
    {
        $con = new DIContainer();
        $creator = new DICreator($con);
        $creator->create(MockItem::class);
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DIProviderException
     * @expectedExceptionMessage cgTag\DI\Test\Mocks\MockItemProvider is not a cgTag\DI\Providers\IDIProvider
     */
    public function shouldThrowDependencyException()
    {
        $con = new DIContainer();
        $classProvider = MockItem::class . 'Provider';
        $con->bind($classProvider)->toConstant('foobar');
        $creator = new DICreator($con);
        $creator->create(MockItem::class);
    }
}
