<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Value\Customer;

use ClawRock\Digiverum\Model\Value\Customer\Name;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ClawRock\Digiverum\Model\Value\Customer\Name
 */
class NameTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Value\Customer\Name::getFirstname
     * @covers \ClawRock\Digiverum\Model\Value\Customer\Name::getMiddlename
     * @covers \ClawRock\Digiverum\Model\Value\Customer\Name::getLastname
     */
    public function testValue()
    {
        $name = new Name('firstname', 'middlename', 'lastname');

        $this->assertEquals('firstname', $name->getFirstname());
        $this->assertEquals('middlename', $name->getMiddlename());
        $this->assertEquals('lastname', $name->getLastname());
    }
}
