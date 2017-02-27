<?php
namespace cgTag\DI\Test\TestCase\DI\Providers;

use cgTag\DI\DIContainer;
use cgTag\DI\Providers\DICreator;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\MockItemProvider;

/**
 * @see \cgTag\DI\Providers\DICreator
 */
class DICreatorTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldCreate()
    {
        $con = $this->getEmptyContainer();
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
        $con = $this->getEmptyContainer();
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
        $con = $this->getEmptyContainer();
        $classProvider = MockItem::class . 'Provider';
        $con->bind($classProvider)->toConstant('foobar');
        $creator = new DICreator($con);
        $creator->create(MockItem::class);
    }
}
