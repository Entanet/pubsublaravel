<?php
/**
 * Created by PhpStorm.
 * User: markjones
 * Date: 2018-12-12
 * Time: 09:09
 */

namespace Entanet\PubSubLaravel;


use ReflectionClass;

class PubSubTestCase extends \Tests\TestCase
{
    protected $pubSubMock;
    protected $pubSubInterfaceMock;
    protected $pubSubKafkaMock;
    protected $pubSubFacadeMock;

    protected function setUp()
    {
        parent::setUp();
        //Mocking pubSubInterface for subscribing to events.
        $this->pubSubInterfaceMock = \Mockery::mock('Superbalist\PubSub\PubSubAdapterInterface');
        $this->app->instance('Superbalist\PubSub\PubSubAdapterInterface', $this->pubSubInterfaceMock);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     *  Allows testing or private/protected functions
     *
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    public function invokeMethod($object, $methodName, array $parameters = []) {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}