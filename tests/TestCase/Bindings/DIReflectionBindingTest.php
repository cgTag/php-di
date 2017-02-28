<?php
namespace cgTag\DI\Test\TestCase\DI\Bindings;

use cgTag\DI\Bindings\DIReflectionBinding;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\MockService;

/**
 * @see \cgTag\DI\Bindings\DIReflectionBinding
 */
class DIReflectionBindingTest extends BaseTestCase
{
    /**
     * @test
     *
     */
    public function shouldGetClass()
    {
        $bind = new DIReflectionBinding(MockItem::class);
        $this->assertInstanceOf(\ReflectionClass::class, $bind->getClass());
    }

    /**
     * @test
     */
    public function shouldGetResolved()
    {
        $con = $this->getEmptyContainer();
        $con->bind('name')->toConstant('house');
        $con->bind('time')->toConstant('ago');

        $this->assertEquals(['house', 'ago'], DIReflectionBinding::getResolved($con, \StdClass::class, ['name', 'time']));
        $this->assertEquals([], DIReflectionBinding::getResolved($con, \StdClass::class, []));
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DIReflectionException
     * @expectedExceptionMessage new StdClass(unknown?)
     */
    public function shouldGetResolvedThrowNotFound()
    {
        $con = $this->getEmptyContainer();
        DIReflectionBinding::getResolved($con, \StdClass::class, ['unknown']);
    }

    /**
     * @test
     * @dataProvider shouldGetSymbolData
     * @param string $name
     * @param callable $func
     */
    public function shouldGetSymbol(string $name, callable $func)
    {
        $reflect = new \ReflectionFunction($func);
        $params = $reflect->getParameters();
        $this->assertCount(1, $params);
        $this->assertSame($name, DIReflectionBinding::getSymbol($params[0]));
    }

    /**
     * @return array
     */
    public function shouldGetSymbolData(): array
    {
        return [
            ['name', function (string $name) {
            }],
            ['name', function (int $name) {
            }],
            ['value', function ($value) {
            }],
            ['options', function (array $options = []) {
            }],
            [MockItem::class, function (MockItem $item) {
            }],
        ];
    }

    /**
     * @test
     * @param callable $func
     * @param array $expected
     * @dataProvider shouldGetSymbolsData
     */
    public function shouldGetSymbols(callable $func, array $expected)
    {
        $this->assertEquals(
            $expected,
            DIReflectionBinding::getSymbols(new \ReflectionFunction($func))
        );
    }

    /**
     * @return array
     */
    public function shouldGetSymbolsData(): array
    {
        return [
            [function (string $name) {

            }, ['name']],
            [function (string $name, int $time) {

            }, ['name', 'time']],
            [function (string $name, MockItem $item) {

            }, ['name', MockItem::class]],
        ];
    }

    /**
     * @test
     */
    public function shouldGetSymbolsTakesNull()
    {
        $this->assertCount(0, DIReflectionBinding::getSymbols(null));
    }

    /**
     * @test
     */
    public function shouldResolve()
    {
        $item = new MockItem();
        $con = $this->getEmptyContainer();
        $con->bind(MockItem::class)->toConstant($item);

        $bind = new DIReflectionBinding(MockService::class);

        /** @var MockService $resolved */
        $resolved = $bind->resolve($con);

        $this->assertInstanceOf(MockService::class, $resolved);
        $this->assertSame($item, $resolved->item);
    }

}
