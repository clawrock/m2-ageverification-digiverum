<?php

namespace ClawRock\Digiverum\Test\Unit\Helper;

use ClawRock\Digiverum\Helper\Config;
use ClawRock\Digiverum\Model\Config\Source\Env;
use ClawRock\MagentoTesting\TestCase;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * @covers \ClawRock\Digiverum\Helper\Config
 */
class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    protected $object;

    protected function setUp()
    {
        $contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $contextMock->expects($this->any())
            ->method('getScopeConfig')
            ->willReturn($this->getScopeConfigMock());

        $this->object = $this->createObject(Config::class, [
            'context' => $contextMock,
        ]);
    }

    /**
     * @covers \ClawRock\Digiverum\Helper\Config::isEnabled
     */
    public function testIsEnabled()
    {
        $this->mockScopeConfigGetValue(Config::CONFIG_ENABLED, '1');
        $this->assertTrue($this->object->isEnabled());
    }

    /**
     * @covers \ClawRock\Digiverum\Helper\Config::getUrl
     */
    public function testGetUrl()
    {
        $this->mockScopeConfigGetValue(Config::CONFIG_URL, 'url');
        $this->assertSame('url', $this->object->getUrl());
    }

    /**
     * @covers \ClawRock\Digiverum\Helper\Config::getQaUrl
     */
    public function testGetQaUrl()
    {
        $this->mockScopeConfigGetValue(Config::CONFIG_QA_URL, 'qa_url');
        $this->assertSame('qa_url', $this->object->getQaUrl());
    }

    /**
     * @covers \ClawRock\Digiverum\Helper\Config::getBrand
     */
    public function testGetBrand()
    {
        $this->mockScopeConfigGetValue(Config::CONFIG_BRAND, 'brand');
        $this->assertSame('brand', $this->object->getBrand());
    }

    /**
     * @covers \ClawRock\Digiverum\Helper\Config::getIp
     */
    public function testGetIp()
    {
        $this->mockScopeConfigGetValue(Config::CONFIG_IP, 'ip');
        $this->assertSame('ip', $this->object->getIp());
    }

    /**
     * @covers \ClawRock\Digiverum\Helper\Config::getEnv
     */
    public function testGetEnv()
    {
        $this->mockScopeConfigGetValue(Config::CONFIG_ENV, 'env');
        $this->assertSame('env', $this->object->getEnv());
    }

    /**
     * @covers \ClawRock\Digiverum\Helper\Config::getGuid
     */
    public function testGetGuid()
    {
        $this->mockScopeConfigGetValue(Config::CONFIG_GUID, 'guid');
        $this->assertSame('guid', $this->object->getGuid());
    }

    /**
     * @covers \ClawRock\Digiverum\Helper\Config::isProdEnv
     */
    public function testIsProdEnv()
    {
        $this->mockScopeConfigGetValue(Config::CONFIG_ENV, Env::PROD);
        $this->assertTrue($this->object->isProdEnv());
    }

    /**
     * @covers \ClawRock\Digiverum\Helper\Config::getEnvUrl
     */
    public function testGetEnvProdUrl()
    {
        $this->getScopeConfigMock()->expects($this->exactly(2))
            ->method('getValue')
            ->withConsecutive([
                Config::CONFIG_ENV,
                ScopeInterface::SCOPE_STORE,
            ], [
                Config::CONFIG_URL,
                ScopeInterface::SCOPE_STORE,
            ])->willReturnOnConsecutiveCalls(Env::PROD, 'url');

        $this->assertSame('url', $this->object->getEnvUrl());
    }

    /**
     * @covers \ClawRock\Digiverum\Helper\Config::getEnvUrl
     */
    public function testGetEnvQaUrl()
    {
        $this->getScopeConfigMock()->expects($this->exactly(2))
            ->method('getValue')
            ->withConsecutive([
                Config::CONFIG_ENV,
                ScopeInterface::SCOPE_STORE,
            ], [
                Config::CONFIG_QA_URL,
                ScopeInterface::SCOPE_STORE,
            ])->willReturnOnConsecutiveCalls(Env::QA, 'qa_url');

        $this->assertSame('qa_url', $this->object->getEnvUrl());
    }
}
