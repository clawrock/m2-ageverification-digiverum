<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Transformer;

use ClawRock\AgeVerification\Model\Transformers\Dob;
use ClawRock\AgeVerification\Model\Values\Dob as DobValue;
use ClawRock\Digiverum\Model\Transformer\Customer;
use ClawRock\Digiverum\Model\Transformer\Customer\Gender;
use ClawRock\Digiverum\Model\Transformer\Customer\Name;
use ClawRock\Digiverum\Model\Transformer\Customer\Ssn;
use ClawRock\Digiverum\Model\Value\Customer as CustomerValue;
use ClawRock\Digiverum\Model\Value\Customer\Gender as GenderValue;
use ClawRock\Digiverum\Model\Value\Customer\Name as NameValue;
use ClawRock\Digiverum\Model\Value\Customer\Ssn as SsnValue;
use ClawRock\MagentoTesting\TestCase;
use Magento\Framework\DataObject;

/**
 * @covers \ClawRock\Digiverum\Model\Transformer\Customer
 */
class CustomerTest extends TestCase
{
    /**
     * @var Name|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $nameTransformerMock;

    /**
     * @var Gender|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $genderTransformerMock;

    /**
     * @var Ssn|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $ssnTransformerMock;

    /**
     * @var Dob|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dobTransformerMock;

    /**
     * @var Customer
     */
    protected $transformer;

    protected function setUp()
    {
        $this->nameTransformerMock = $this->getMockBuilder(Name::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->genderTransformerMock = $this->getMockBuilder(Gender::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->ssnTransformerMock = $this->getMockBuilder(Ssn::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dobTransformerMock = $this->getMockBuilder(Dob::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transformer = $this->createObject(Customer::class, [
            'name'   => $this->nameTransformerMock,
            'gender' => $this->genderTransformerMock,
            'ssn'    => $this->ssnTransformerMock,
            'dob'    => $this->dobTransformerMock,
        ]);
    }

    /**
     * @covers \ClawRock\Digiverum\Model\Transformer\Customer::transform
     */
    public function testTransformer()
    {
        $date = new \DateTime();

        $this->nameTransformerMock->expects($this->once())
            ->method('transform')
            ->willReturn(new NameValue('firstname', null, 'lastname'));

        $this->genderTransformerMock->expects($this->once())
            ->method('transform')
            ->willReturn(new GenderValue('Male'));

        $this->ssnTransformerMock->expects($this->once())
            ->method('transform')
            ->willReturn(new SsnValue('1234'));

        $this->dobTransformerMock->expects($this->once())
            ->method('transform')
            ->willReturn(new DobValue($date));

        /** @var CustomerValue $customer */
        $customer = $this->transformer->transform(new DataObject());

        $this->assertEquals([
            CustomerValue::FIRSTNAME_KEY  => 'firstname',
            CustomerValue::MIDDLENAME_KEY => null,
            CustomerValue::LASTNAME_KEY   => 'lastname',
            CustomerValue::GENDER_KEY     => 'Male',
            CustomerValue::DOB_KEY        => $date->format('m/d/Y'),
            CustomerValue::SSN_KEY        => '1234',
        ], $customer->toArray());
    }
}
