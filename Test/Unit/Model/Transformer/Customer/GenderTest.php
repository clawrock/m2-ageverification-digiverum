<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Transformer\Customer;

use ClawRock\Digiverum\Model\Transformer\Customer\Gender;
use ClawRock\MagentoTesting\TestCase;
use Magento\Framework\DataObject;

/**
 * @covers \ClawRock\Digiverum\Model\Transformer\Customer\Gender
 */
class GenderTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Transformer\Customer\Gender::transform
     */
    public function testTransformer()
    {
        /** @var Gender $gender */
        $transformer = $this->createObject(Gender::class);

        $gender = $transformer->transform(new DataObject([
            Gender::GENDER_FIELD => '1',
        ]));

        $this->assertEquals('Male', $gender->getValue());
    }
}
