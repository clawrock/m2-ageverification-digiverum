<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Value;

use ClawRock\Digiverum\Model\Value\Address;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ClawRock\Digiverum\Model\Value\Address
 */
class AddressTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Value\Address::toArray
     */
    public function testValue()
    {
        $address = new Address(['street1', 'street2'], 'city', 'region', 'postcode');

        $this->assertEquals([
            Address::ADDRESS1_KEY => 'street1',
            Address::ADDRESS2_KEY => 'street2',
            Address::STATE_KEY    => 'region',
            Address::CITY_KEY     => 'city',
            Address::ZIP_KEY      => 'postcode',
        ], $address->toArray());
    }
}
