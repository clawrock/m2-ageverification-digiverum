<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Value\Customer;

use ClawRock\Digiverum\Model\Value\Customer\Gender;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ClawRock\Digiverum\Model\Value\Customer\Gender
 */
class GenderTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Value\Customer\Gender::getValue
     */
    public function testValue()
    {
        $gender = new Gender('Male');

        $this->assertEquals('Male', $gender->getValue());
    }

    /**
     * @covers \ClawRock\Digiverum\Model\Value\Customer\Gender::getValue
     */
    public function testIncorrectValue()
    {
        $this->expectException(\RangeException::class);

        new Gender('wrong_value');
    }
}
