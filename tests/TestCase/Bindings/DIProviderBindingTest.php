<?php
namespace cgTag\DI\Test\TestCase\Bindings;

use cgTag\DI\Bindings\DIProviderBinding;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItemProvider;

class DIProviderBindingTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider shouldAllowArgumentData
     * @param $value
     */
    public function shouldAllowArgument($value)
    {
        $binding = new DIProviderBinding($value);
        $this->assertSame($value, $binding->provider);
    }

    /**
     * @return array
     */
    public function shouldAllowArgumentData(): array
    {
        return [
            ['FooBar'],
            [MockItemProvider::class],
            [new MockItemProvider()]
        ];
    }

    /**
     * @test
     * @expectedException \cgTag\DI\Exceptions\DIArgumentException
     * @expectedExceptionMessage Provider of wrong type
     * @dataProvider shouldThrowArgumentErrorData
     * @param mixed $value
     */
    public function shouldThrowArgumentError($value)
    {
        new DIProviderBinding($value);
    }

    /**
     * @return array
     */
    public function shouldThrowArgumentErrorData(): array
    {
        return [
            [null],
            [0],
            [new \stdClass()]
        ];
    }

}