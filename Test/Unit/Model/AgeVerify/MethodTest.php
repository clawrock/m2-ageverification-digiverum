<?php

namespace ClawRock\Digiverum\Test\Unit\Model\AgeVerify;

use ClawRock\AgeVerification\Api\Data\PersistableResultInterface;
use ClawRock\AgeVerification\Api\Data\ResultInterface;
use ClawRock\Digiverum\Helper\Config;
use ClawRock\Digiverum\Model\AgeVerify\Method;
use ClawRock\Digiverum\Model\Client;
use ClawRock\Digiverum\Model\Transformer\AgeVerify;
use ClawRock\Digiverum\Model\Value\AgeVerify as AgeVerifyValue;
use ClawRock\MagentoTesting\TestCase;
use Magento\Customer\Model\Customer;
use Magento\Framework\DataObject;

/**
 * @covers \ClawRock\Digiverum\Model\AgeVerify\Method
 */
class MethodTest extends TestCase
{
    /**
     * @var \Magento\Customer\Model\Customer|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerMock;

    /**
     * @var AgeVerify|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $ageVerifyMock;

    /**
     * @var AgeVerifyValue|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $ageVerifyValueMock;

    /**
     * @var Client|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $clientMock;

    /**
     * @var Config|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configMock;

    /**
     * @var Method
     */
    protected $object;

    protected function setUp()
    {
        $this->customerMock = $this->getMockBuilder(Customer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->ageVerifyMock = $this->getMockBuilder(AgeVerify::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->ageVerifyValueMock = $this->getMockBuilder(AgeVerifyValue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = $this->createObject(Method::class, [
            'ageVerify' => $this->ageVerifyMock,
            'client'    => $this->clientMock,
            'config'    => $this->configMock,
        ]);
    }

    /**
     * @covers \ClawRock\Digiverum\Model\AgeVerify\Method::getTitle
     */
    public function testGetTitle()
    {
        $this->assertEquals(Method::METHOD_TITLE, $this->object->getTitle());
    }

    /**
     * @covers \ClawRock\Digiverum\Model\AgeVerify\Method::isValid
     */
    public function testIsValid()
    {
        $this->configMock->expects($this->once())->method('isEnabled')->willReturn(true);
        $this->assertTrue($this->object->isValid());
    }

    /**
     * @covers \ClawRock\Digiverum\Model\AgeVerify\Method::isCustomerAuthenticated
     */
    public function testIsCustomerAuthenticated()
    {
        $this->customerMock->expects($this->exactly(3))
            ->method('getData')
            ->withConsecutive(
                [PersistableResultInterface::IS_VERIFIED_FIELD],
                [PersistableResultInterface::TOKEN_FIELD],
                [PersistableResultInterface::METHOD_FIELD]
            )
            ->willReturnOnConsecutiveCalls('1', 'token', 'method');

        $this->assertTrue($this->object->isCustomerAuthenticated($this->customerMock));
    }

    /**
     * @covers \ClawRock\Digiverum\Model\AgeVerify\Method::authenticate
     */
    public function testAuthenticate()
    {
        $request = new DataObject();

        $this->ageVerifyMock->expects($this->once())
            ->method('transform')
            ->with($request)
            ->willReturn($this->ageVerifyValueMock);

        $requestArr = [
            'first_name' => 'First Name',
            'last_name'  => 'Last Name',
        ];

        $result = $this->getMockBuilder(ResultInterface::class)->getMockForAbstractClass();

        $this->ageVerifyMock->expects($this->once())
            ->method('transform')
            ->with($request)
            ->willReturn($this->ageVerifyValueMock);

        $this->ageVerifyValueMock->expects($this->once())->method('toArray')->willReturn($requestArr);
        $this->clientMock->expects($this->once())->method('authenticate')->with($requestArr)->willReturn($result);

        $this->assertInstanceOf(ResultInterface::class, $this->object->authenticate($request));
    }
}
