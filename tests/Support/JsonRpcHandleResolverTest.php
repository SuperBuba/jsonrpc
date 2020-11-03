<?php

namespace Tochka\JsonRpc\Tests\Support;

use PHPUnit\Framework\TestCase;
use Tochka\JsonRpc\Exceptions\JsonRpcException;
use Tochka\JsonRpc\Support\JsonRpcHandleResolver;
use Tochka\JsonRpc\Support\JsonRpcRequest;
use Tochka\JsonRpc\Tests\TestHelpers\ReflectionTrait;

class JsonRpcHandleResolverTest extends TestCase
{
    use ReflectionTrait;

    public $resolver;

    public function setUp(): void
    {
        parent::setUp();
        $this->resolver = new JsonRpcHandleResolver();
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::setMethodDelimiter
     * @throws \ReflectionException
     */
    public function testSetMethodDelimiter(): void
    {
        $delimiter = 'same';

        $this->resolver->setMethodDelimiter($delimiter);
        $actualDelimiter = $this->getProperty($this->resolver, 'methodDelimiter');

        $this->assertEquals($delimiter, $actualDelimiter);
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::setControllerSuffix
     * @throws \ReflectionException
     */
    public function testSetControllerSuffix(): void
    {
        $suffix = 'same';

        $this->resolver->setControllerSuffix($suffix);
        $actualSuffix = $this->getProperty($this->resolver, 'controllerSuffix');

        $this->assertEquals($suffix, $actualSuffix);
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::resolve
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     * @throws \Tochka\JsonRpc\Exceptions\JsonRpcException
     */
    public function testResolveIncorrectJsonRpcEmptyJsonRpc(): void
    {
        $call = (object) [
            'method' => 'same_method',
        ];

        $request = new JsonRpcRequest($call);

        $this->expectException(JsonRpcException::class);
        $this->expectExceptionCode(JsonRpcException::CODE_INVALID_REQUEST);

        $this->resolver->resolve($request, '');
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::resolve
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     * @throws \Tochka\JsonRpc\Exceptions\JsonRpcException
     */
    public function testResolveIncorrectJsonRpcIncorrectVersion(): void
    {
        $call = (object) [
            'jsonrpc' => '3.0',
            'method'  => 'same_method',
        ];

        $request = new JsonRpcRequest($call);

        $this->expectException(JsonRpcException::class);
        $this->expectExceptionCode(JsonRpcException::CODE_INVALID_REQUEST);

        $this->resolver->resolve($request, '');
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::resolve
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     * @throws \Tochka\JsonRpc\Exceptions\JsonRpcException
     */
    public function testResolveIncorrectJsonRpcEmptyMethod(): void
    {
        $call = (object) [
            'jsonrpc' => '2.0',
        ];

        $request = new JsonRpcRequest($call);

        $this->expectException(JsonRpcException::class);
        $this->expectExceptionCode(JsonRpcException::CODE_INVALID_REQUEST);

        $this->resolver->resolve($request, '');
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::resolve
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     * @throws \Tochka\JsonRpc\Exceptions\JsonRpcException
     */
    // public function testResolve(): void
    // {
    //     $call = (object) [
    //         'jsonrpc' => '3.0',
    //         'method'  => 'same_method',
    //     ];
    //
    //     $request = new JsonRpcRequest($call);
    //
    //     //\Mockery::mock()
    //
    //     $this->resolver->resolve($request, '');
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getCanonicalTypeName
     * @throws \ReflectionException
     */
    public function testGetCanonicalTypeName(): void
    {
        $stringType = $this->callMethod($this->resolver, 'getCanonicalTypeName', ['String']);
        $strType = $this->callMethod($this->resolver, 'getCanonicalTypeName', ['Str']);
        $integerType = $this->callMethod($this->resolver, 'getCanonicalTypeName', ['Integer']);
        $intType = $this->callMethod($this->resolver, 'getCanonicalTypeName', ['int']);
        $floatType = $this->callMethod($this->resolver, 'getCanonicalTypeName', ['float']);
        $doubleType = $this->callMethod($this->resolver, 'getCanonicalTypeName', ['Double']);
        $boolType = $this->callMethod($this->resolver, 'getCanonicalTypeName', ['bool']);
        $booleanType = $this->callMethod($this->resolver, 'getCanonicalTypeName', ['boolean']);
        $objectType = $this->callMethod($this->resolver, 'getCanonicalTypeName', ['stdClass']);

        $this->assertEquals('string', $stringType);
        $this->assertEquals('string', $strType);
        $this->assertEquals('integer', $integerType);
        $this->assertEquals('integer', $intType);
        $this->assertEquals('double', $floatType);
        $this->assertEquals('double', $doubleType);
        $this->assertEquals('boolean', $boolType);
        $this->assertEquals('boolean', $booleanType);
        $this->assertEquals('object', $objectType);
    }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::initializeController
     */
    // public function testInitializeControllerWithoutClass(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::initializeController
     */
    // public function testInitializeControllerWithErrorDI(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::initializeController
     */
    // public function testInitializeControllerWithoutMethod(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::initializeController
     */
    // public function testInitializeControllerWithForbiddenMethod(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::initializeController
     */
    // public function testInitializeControllerWithSetRequest(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::initializeController
     */
    // public function testInitializeControllerWithoutSetRequest(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getHandledMethod
     */
    // public function testGetHandledMethodWithoutGroupAndAction(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getHandledMethod
     */
    // public function testGetHandledMethodWithGroupAndWithoutAction(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getHandledMethod
     */
    // public function testGetHandledMethodWithGroupAndAction(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getHandledMethod
     */
    // public function testGetHandledMethodWithIncorrectMethodName(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getHandledMethod
     */
    // public function testGetHandledMethodWithCustomControllerSuffix(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getCallParams
     */
    // public function testGetCallParamsEmptyParams(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getCallParams
     */
    // public function testGetCallParamsIncorrectTypes(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getCallParams
     */
    // public function testGetCallParamsWithoutRequired(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getCallParams
     */
    // public function testGetCallParamsWithDefaultValues(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getCallParams
     */
    // public function testGetCallParamsExtraParams(): void
    // {
    //
    // }

    /**
     * @covers \Tochka\JsonRpc\Support\JsonRpcHandleResolver::getCallParams
     */
    // public function testGetCallParamsNormal(): void
    // {
    //
    // }
}
