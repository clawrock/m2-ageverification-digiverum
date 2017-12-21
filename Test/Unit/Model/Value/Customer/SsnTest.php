<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Value\Customer;

use ClawRock\Digiverum\Model\Value\Customer\Ssn;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ClawRock\Digiverum\Model\Value\Customer\Ssn
 */
class SsnTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Value\Customer\Ssn::getValue
     */
    public function testValue()
    {
        $ssn = new Ssn('1234');

        $this->assertEquals('1234', $ssn->getValue());
    }

    /**
     * @covers \ClawRock\Digiverum\Model\Value\Customer\Ssn::getValue
     */
    public function testEmpty()
    {
        $ssn = new Ssn();

        $this->assertEquals('', $ssn->getValue());
    }
}
