<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Transformer\Customer;

use ClawRock\Digiverum\Model\Transformer\Customer\Ssn;
use ClawRock\MagentoTesting\TestCase;
use Magento\Framework\DataObject;

/**
 * @covers \ClawRock\Digiverum\Model\Transformer\Customer\Ssn
 */
class SsnTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Transformer\Customer\Ssn::transform
     */
    public function testTransformer()
    {
        /** @var Ssn $transformer */
        $transformer = $this->createObject(Ssn::class);

        /** @var \ClawRock\Digiverum\Model\Value\Customer\Ssn $ssn */
        $ssn = $transformer->transform(new DataObject([
            Ssn::SSN_FIELD => '1234',
        ]));

        $this->assertEquals('1234', $ssn->getValue());
    }
}
