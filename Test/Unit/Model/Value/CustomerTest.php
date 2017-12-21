<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Value;

use ClawRock\AgeVerification\Model\Values\Dob;
use ClawRock\Digiverum\Model\Value\Customer;
use ClawRock\Digiverum\Model\Value\Customer\Gender;
use ClawRock\Digiverum\Model\Value\Customer\Name;
use ClawRock\Digiverum\Model\Value\Customer\Ssn;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ClawRock\Digiverum\Model\Value\Customer
 */
class CustomerTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Value\Customer::toArray
     */
    public function testValue()
    {
        $date = new \DateTime();
        $name = new Name('firstname', null, 'lastname');
        $gender = new Gender('Male');
        $ssn = new Ssn('1234');
        $dob = new Dob($date);
        $customer = new Customer($name, $gender, $ssn, $dob);

        $this->assertEquals([
            Customer::FIRSTNAME_KEY  => 'firstname',
            Customer::MIDDLENAME_KEY => null,
            Customer::LASTNAME_KEY   => 'lastname',
            Customer::GENDER_KEY     => 'Male',
            Customer::DOB_KEY        => $date->format('m/d/Y'),
            Customer::SSN_KEY        => '1234',
        ], $customer->toArray());
    }
}
