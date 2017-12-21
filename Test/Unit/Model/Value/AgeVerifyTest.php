<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Value;

use ClawRock\AgeVerification\Model\Values\Dob;
use ClawRock\Digiverum\Model\Value\Address;
use ClawRock\Digiverum\Model\Value\AgeVerify;
use ClawRock\Digiverum\Model\Value\Config;
use ClawRock\Digiverum\Model\Value\Customer;
use ClawRock\Digiverum\Model\Value\Customer\Gender;
use ClawRock\Digiverum\Model\Value\Customer\Name;
use ClawRock\Digiverum\Model\Value\Customer\Ssn;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ClawRock\Digiverum\Model\Value\AgeVerify
 */
class AgeVerifyTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Value\AgeVerify::toArray
     */
    public function testValue()
    {
        $date = new \DateTime();
        $name = new Name('firstname', null, 'lastname');
        $gender = new Gender('Male');
        $ssn = new Ssn('1234');
        $dob = new Dob($date);
        $customer = new Customer($name, $gender, $ssn, $dob);

        $address = new Address(['street1', 'street2'], 'city', 'region', 'postcode');

        $config = new Config('brand', 'env', '127.0.0.1', 'guid');

        $ageVerify = new AgeVerify($customer, $address, $config);

        $this->assertEquals([
            AgeVerify::PAYLOAD_KEY => [
                Customer::FIRSTNAME_KEY  => 'firstname',
                Customer::MIDDLENAME_KEY => null,
                Customer::LASTNAME_KEY   => 'lastname',
                Customer::GENDER_KEY     => 'Male',
                Customer::DOB_KEY        => $date->format('m/d/Y'),
                Customer::SSN_KEY        => '1234',
                Address::ADDRESS1_KEY    => 'street1',
                Address::ADDRESS2_KEY    => 'street2',
                Address::STATE_KEY       => 'region',
                Address::CITY_KEY        => 'city',
                Address::ZIP_KEY         => 'postcode',
                Config::BRAND_KEY        => 'brand',
                Config::ENV_KEY          => 'env',
                Config::IP_KEY           => '127.0.0.1',
                Config::GUID_KEY         => 'guid',
            ],
        ], $ageVerify->toArray());
    }
}
