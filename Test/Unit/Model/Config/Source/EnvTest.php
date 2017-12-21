<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Config\Source;

use ClawRock\Digiverum\Model\Config\Source\Env;
use ClawRock\MagentoTesting\TestCase;

/**
 * @covers \ClawRock\Digiverum\Model\Config\Source\Env
 */
class EnvTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Config\Source\Env::toOptionArray
     */
    public function testToOptionArray()
    {
        $object = $this->createObject(Env::class);

        $options = $object->toOptionArray();

        foreach ($options as $option) {
            $this->assertArrayHasKey('value', $option);
            $this->assertArrayHasKey('label', $option);
        }
    }
}
