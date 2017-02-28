<?php
namespace cgTag\DI\Test\TestCase\Providers;

use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\MockItemProvider;

class DIProviderTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldUseProviderForMockItem()
    {
        $con = $this->getEmptyContainer();
        $con->bind('FooBarProvider')->toClass(MockItemProvider::class);
        $con->bind('ForBar')->withProvider('FooBarProvider');

        $item = $con->get('ForBar', ['options' => [1]]);

        $this->assertInstanceOf(MockItem::class, $item);
    }
}