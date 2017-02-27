<?php
namespace cgTag\DI\Test\TestCase\Locators;

use cgTag\DI\Bindings\DIReflectionBinding;
use cgTag\DI\IDIContainer;
use cgTag\DI\Locators\DILocatorService;
use cgTag\DI\Test\BaseTestCase;
use cgTag\DI\Test\Mocks\MockItem;
use cgTag\DI\Test\Mocks\MockItemProvider;
use cgTag\DI\Test\Mocks\MockService;

class DILocatorServiceTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider shouldReturnNullData
     * @param string $symbol
     */
    public function shouldReturnNull(string $symbol)
    {
        $locator = new DILocatorService();
        $this->assertNull($locator->find($symbol));
    }

    /**
     * @return array
     */
    public function shouldReturnNullData(): array
    {
        return [
            ['foo'],
            [\stdClass::class],
            [MockItem::class],
            [MockItemProvider::class]
        ];
    }

    /**
     * @test
     * @dataProvider shouldReturnReflectionBindingData
     * @param string $symbol
     */
    public function shouldReturnReflectionBinding(string $symbol)
    {
        $locator = new DILocatorService();
        /** @var DIReflectionBinding $binding */
        $binding = $locator->find($symbol);
        $this->assertInstanceOf(DIReflectionBinding::class, $binding);
        $this->assertSame($symbol, $binding->getClassName());
    }

    /**
     * @return array
     */
    public function shouldReturnReflectionBindingData(): array
    {
        return [
            [MockService::class]
        ];
    }

    /**
     * @test
     * @dataProvider shouldVerifyClassNameData
     * @param string $className
     */
    public function shouldVerifyClassName(string $className)
    {
        $this->assertTrue(DILocatorService::isClassName($className));
    }

    /**
     * @return array
     */
    public function shouldVerifyClassNameData(): array
    {
        return [
            [IDIContainer::class],
            [MockService::class],
            ['Foo\\Bar\\Service\\AppService'],
            ['a\a']
        ];
    }

    /**
     * @test
     * @dataProvider shouldVerifyDocBlockIsServiceData
     * @param string $phpDoc
     */
    public function shouldVerifyDocBlockIsService(string $phpDoc)
    {
        $this->assertTrue(DILocatorService::isService($phpDoc));
    }

    /**
     * @return array
     */
    public function shouldVerifyDocBlockIsServiceData(): array
    {
        return [
            ['/** @service */'],
            ["/**\n * @service With description.\n**/"],
            ["/**\n*@service*/"],
            ["/**@service*/"],
        ];
    }

    /**
     * @test
     * @dataProvider shouldVerifyNotClassNameData
     * @param string $className
     */
    public function shouldVerifyNotClassName(string $className)
    {
        $this->assertFalse(DILocatorService::isClassName($className));
    }

    /**
     * @return array
     */
    public function shouldVerifyNotClassNameData(): array
    {
        return [
            [\stdClass::class],
            [\Exception::class],
            ['a'],
            ['\\a'],
            ['a\\'],
            [''],
            ['abcdefg']
        ];
    }

    /**
     * @test
     * @dataProvider shouldVerifyNotServiceUsingMockData
     * @param string $className
     */
    public function shouldVerifyNotServiceUsingMock(string $className)
    {
        $reflect = new \ReflectionClass($className);
        $doc = $reflect->getDocComment();
        $this->assertFalse(DILocatorService::isService($doc));
    }

    /**
     * @return array
     */
    public function shouldVerifyNotServiceUsingMockData(): array
    {
        return [
            [MockItem::class],
            [MockItemProvider::class]
        ];
    }

    /**
     * @test
     * @dataProvider shouldVerifyServiceViaReflectionData
     * @param string $className
     */
    public function shouldVerifyServiceViaReflection(string $className)
    {
        $reflect = new \ReflectionClass($className);
        $doc = $reflect->getDocComment();
        $this->assertTrue(DILocatorService::isService($doc));
    }

    /**
     * @return array
     */
    public function shouldVerifyServiceViaReflectionData(): array
    {
        return [
            [MockService::class]
        ];
    }
}