<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Value;

use ClawRock\Digiverum\Model\Value\Config;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ClawRock\Digiverum\Model\Value\Config
 */
class ConfigTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Value\Config::toArray
     */
    public function testValue()
    {
        $config = new Config('brand', 'env', '127.0.0.1', 'guid');

        $this->assertEquals([
            Config::BRAND_KEY => 'brand',
            Config::ENV_KEY   => 'env',
            Config::IP_KEY    => '127.0.0.1',
            Config::GUID_KEY  => 'guid',
        ], $config->toArray());
    }
}
