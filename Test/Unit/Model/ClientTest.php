<?php

namespace ClawRock\Digiverum\Test\Unit\Model;

use ClawRock\AgeVerification\Exception\CustomerAuthenticationException;
use ClawRock\Digiverum\Helper\Config;
use ClawRock\Digiverum\Model\Client;
use ClawRock\Digiverum\Model\Result;
use ClawRock\MagentoTesting\TestCase;
use Magento\Framework\HTTP\Client\Curl;

/**
 * @covers \ClawRock\Digiverum\Model\Client
 */
class ClientTest extends TestCase
{
    const API_URL = 'http://api.digiverum.dev';

    /**
     * @var Curl|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $httpClientMock;

    /**
     * @var Config|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configMock;

    /**
     * @var Client
     */
    protected $object;

    protected function setUp()
    {
        $this->httpClientMock = $this->getMockBuilder(Curl::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = $this->createObject(Client::class, [
            'httpClient' => $this->httpClientMock,
            'config'     => $this->configMock,
        ]);
    }

    /**
     * @covers \ClawRock\Digiverum\Model\Client::authenticate
     */
    public function testAuthenticateSuccess()
    {
        $this->configMock->expects($this->once())->method('getEnvUrl')->willReturn(self::API_URL);
        $this->httpClientMock->expects($this->once())->method('post')->with(self::API_URL, '[]');
        $this->httpClientMock->expects($this->once())->method('getBody')->willReturn(json_encode([
            'VerifyResult' => [
                'code'     => Result::VERIFIED_CODE,
                'trans_id' => '1',
            ],
        ]));

        $result = $this->object->authenticate([]);

        $this->assertTrue($result->isAuthorized());
    }

    /**
     * @covers \ClawRock\Digiverum\Model\Client::authenticate
     */
    public function testAuthenticateFailure()
    {
        $this->expectException(CustomerAuthenticationException::class);

        $this->configMock->expects($this->once())->method('getEnvUrl')->willReturn(self::API_URL);
        $this->httpClientMock->expects($this->once())->method('post')->with(self::API_URL, '[]');
        $this->httpClientMock->expects($this->once())->method('getBody')->willReturn(json_encode([
            'VerifyResult' => [
                'code' => Result::NOT_VERIFIED_CODE,
            ],
        ]));

        $this->object->authenticate([]);
    }

    /**
     * @covers \ClawRock\Digiverum\Model\Client::authenticate
     */
    public function testAuthenticateIncorrectResponse()
    {
        $this->expectException(CustomerAuthenticationException::class);

        $this->configMock->expects($this->once())->method('getEnvUrl')->willReturn(self::API_URL);
        $this->httpClientMock->expects($this->once())->method('post')->with(self::API_URL, '[]');
        $this->httpClientMock->expects($this->once())->method('getBody')->willReturn(json_encode([]));

        $this->object->authenticate([]);
    }
}
