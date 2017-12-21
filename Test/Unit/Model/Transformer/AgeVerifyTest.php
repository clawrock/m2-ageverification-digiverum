<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Transformer;

use ClawRock\AgeVerification\Model\Values\Dob;
use ClawRock\Digiverum\Model\Transformer\Address;
use ClawRock\Digiverum\Model\Transformer\AgeVerify;
use ClawRock\Digiverum\Model\Transformer\Config;
use ClawRock\Digiverum\Model\Transformer\Customer;
use ClawRock\Digiverum\Model\Value\Address as AddressValue;
use ClawRock\Digiverum\Model\Value\AgeVerify as AgeVerifyValue;
use ClawRock\Digiverum\Model\Value\Config as ConfigValue;
use ClawRock\Digiverum\Model\Value\Customer as CustomerValue;
use ClawRock\Digiverum\Model\Value\Customer\Gender;
use ClawRock\Digiverum\Model\Value\Customer\Name;
use ClawRock\Digiverum\Model\Value\Customer\Ssn;
use ClawRock\MagentoTesting\TestCase;
use Magento\Framework\DataObject;

/**
 * @covers \ClawRock\Digiverum\Model\Transformer\AgeVerify
 */
class AgeVerifyTest extends TestCase
{
    /**
     * @var Customer|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerTransformerMock;

    /**
     * @var Address|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressTransformerMock;

    /**
     * @var Config|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configTransformerMock;

    /**
     * @var AgeVerify
     */
    protected $transformer;

    protected function setUp()
    {
        $this->customerTransformerMock = $this->getMockBuilder(Customer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressTransformerMock = $this->getMockBuilder(Address::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configTransformerMock = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transformer = $this->createObject(AgeVerify::class, [
            'customer' => $this->customerTransformerMock,
            'address'  => $this->addressTransformerMock,
            'config'   => $this->configTransformerMock,
        ]);
    }

    /**
     * @covers \ClawRock\Digiverum\Model\Transformer\AgeVerify::transform
     */
    public function testTransformer()
    {
        $date = new \DateTime();

        $this->customerTransformerMock->expects($this->once())
            ->method('transform')
            ->willReturn(new CustomerValue(
                new Name('firstname', 'middlename', 'lastname'),
                new Gender('Male'),
                new Ssn('1234'),
                new Dob($date)
            ));

        $this->addressTransformerMock->expects($this->once())
            ->method('transform')
            ->willReturn(new AddressValue(['street1', 'street2'], 'city', 'region', 'postcode'));

        $this->configTransformerMock->expects($this->once())
            ->method('transform')
            ->willReturn(new ConfigValue('brand', 'env', '127.0.0.1', 'guid'));

        $ageVerify = $this->transformer->transform(new DataObject());

        $this->assertEquals([
            AgeVerifyValue::PAYLOAD_KEY => [
                CustomerValue::FIRSTNAME_KEY  => 'firstname',
                CustomerValue::MIDDLENAME_KEY => 'middlename',
                CustomerValue::LASTNAME_KEY   => 'lastname',
                CustomerValue::GENDER_KEY     => 'Male',
                CustomerValue::DOB_KEY        => $date->format('m/d/Y'),
                CustomerValue::SSN_KEY        => '1234',
                AddressValue::ADDRESS1_KEY    => 'street1',
                AddressValue::ADDRESS2_KEY    => 'street2',
                AddressValue::STATE_KEY       => 'region',
                AddressValue::CITY_KEY        => 'city',
                AddressValue::ZIP_KEY         => 'postcode',
                ConfigValue::BRAND_KEY        => 'brand',
                ConfigValue::ENV_KEY          => 'env',
                ConfigValue::IP_KEY           => '127.0.0.1',
                ConfigValue::GUID_KEY         => 'guid',
            ],
        ], $ageVerify->toArray());
    }
}
