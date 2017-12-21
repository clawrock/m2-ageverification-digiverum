<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Transformer;

use ClawRock\Digiverum\Helper\Config as ConfigHelper;
use ClawRock\Digiverum\Model\Transformer\Config;
use ClawRock\Digiverum\Model\Value\Config as ConfigValue;
use ClawRock\MagentoTesting\TestCase;

/**
 * @covers \ClawRock\Digiverum\Model\Transformer\Config
 */
class ConfigTest extends TestCase
{
    /**
     * @var ConfigHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configMock;

    /**
     * @var Config
     */
    protected $transformer;

    protected function setUp()
    {
        $this->configMock = $this->getMockBuilder(ConfigHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transformer = $this->createObject(Config::class, [
            'config' => $this->configMock
        ]);
    }

    /**
     * @covers \ClawRock\Digiverum\Model\Transformer\Config::transform
     */
    public function testTransformer()
    {
        $this->configMock->expects($this->once())->method('getBrand')->willReturn('brand');
        $this->configMock->expects($this->once())->method('getEnv')->willReturn('env');
        $this->configMock->expects($this->once())->method('getIp')->willReturn('127.0.0.1');
        $this->configMock->expects($this->once())->method('getGuid')->willReturn('guid');

        $config = $this->transformer->transform();

        $this->assertEquals([
            ConfigValue::BRAND_KEY => 'brand',
            ConfigValue::ENV_KEY   => 'env',
            ConfigValue::IP_KEY    => '127.0.0.1',
            ConfigValue::GUID_KEY  => 'guid',
        ], $config->toArray());
    }
}
