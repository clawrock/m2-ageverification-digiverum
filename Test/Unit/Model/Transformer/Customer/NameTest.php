<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Transformer\Customer;

use ClawRock\Digiverum\Model\Transformer\Customer\Name;
use ClawRock\MagentoTesting\TestCase;
use Magento\Framework\DataObject;

/**
 * @covers \ClawRock\Digiverum\Model\Transformer\Customer\Name
 */
class NameTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Transformer\Customer\Name::transform
     */
    public function testTransformer()
    {
        /** @var Name $transformer */
        $transformer = $this->createObject(Name::class);

        /** @var \ClawRock\Digiverum\Model\Value\Customer\Name $name */
        $name = $transformer->transform(new DataObject([
            Name::FIRSTNAME_FIELD => 'firstname',
            Name::LASTNAME_FIELD  => 'lastname',
        ]));

        $this->assertEquals('firstname', $name->getFirstname());
        $this->assertEquals('', $name->getMiddlename());
        $this->assertEquals('lastname', $name->getLastname());
    }
}
