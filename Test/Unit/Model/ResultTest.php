<?php

namespace ClawRock\Digiverum\Test\Unit\Model;

use ClawRock\AgeVerification\Api\Data\PersistableResultInterface;
use ClawRock\AgeVerification\Exception\CustomerAuthenticationException;
use ClawRock\Digiverum\Model\Result;
use ClawRock\MagentoTesting\TestCase;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Model\AddressFactory;
use Magento\Customer\Model\Config\Share;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Address\CollectionFactory;
use Magento\Customer\Model\ResourceModel\Customer as CustomerResource;
use Magento\Eav\Model\Config;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Indexer\IndexerRegistry;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Model\Context;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime;
use Magento\Store\Model\StoreManagerInterface;

/**
 * @covers \ClawRock\Digiverum\Model\Result
 */
class ResultTest extends TestCase
{
    /**
     * @covers \ClawRock\Digiverum\Model\Result::isAuthorized
     * @covers \ClawRock\Digiverum\Model\Result::persistInCustomerData
     */
    public function testSuccessResult()
    {
        $response = json_encode([
            'VerifyResult' => [
                'code'     => Result::VERIFIED_CODE,
                'trans_id' => '1',
            ],
        ]);

        $result = new Result($response);

        $this->assertTrue($result->isAuthorized());

        /** @var Customer $customer */
        $customer = $this->getCustomerMock();

        $result->persistInCustomerData($customer, 'digiverum');

        $this->assertTrue($customer->getData(PersistableResultInterface::IS_VERIFIED_FIELD));
        $this->assertEquals('digiverum', $customer->getData(PersistableResultInterface::METHOD_FIELD));
        $this->assertEquals('1', $customer->getData(PersistableResultInterface::TOKEN_FIELD));
    }

    /**
     * @covers \ClawRock\Digiverum\Model\Result::isAuthorized
     */
    public function testFailureResult()
    {
        $this->expectException(CustomerAuthenticationException::class);

        $response = json_encode([
            'VerifyResult' => [
                'code' => Result::NOT_VERIFIED_CODE,
            ],
        ]);

        new Result($response);
    }

    protected function getCustomerMock()
    {
        $contextMock = $this->getMockBuilder(Context::class)->disableOriginalConstructor()->getMock();
        $registryMock = $this->getMockBuilder(Registry::class)->disableOriginalConstructor()->getMock();
        $storeManagerMock = $this->getMockBuilder(StoreManagerInterface::class)->getMockForAbstractClass();
        $configMock = $this->getMockBuilder(Config::class)->disableOriginalConstructor()->getMock();
        $scopeConfigMock = $this->getMockBuilder(ScopeConfigInterface::class)->getMockForAbstractClass();
        $resourceMock = $this->getMockBuilder(CustomerResource::class)->disableOriginalConstructor()->getMock();
        $configShareMock = $this->getMockBuilder(Share::class)->disableOriginalConstructor()->getMock();
        $addressFactoryMock = $this->getMockBuilder(AddressFactory::class)->disableOriginalConstructor()->getMock();
        $addressesFactoryMock = $this->getMockBuilder(CollectionFactory::class)->disableOriginalConstructor()->getMock();
        $transportBuilderMock = $this->getMockBuilder(TransportBuilder::class)->disableOriginalConstructor()->getMock();
        $groupRepositoryMock = $this->getMockBuilder(GroupRepositoryInterface::class)->getMockForAbstractClass();
        $encryptorMock = $this->getMockBuilder(EncryptorInterface::class)->getMockForAbstractClass();
        $dateTimeMock = $this->getMockBuilder(DateTime::class)->disableOriginalConstructor()->getMock();
        $customerDataFactoryMock = $this->getMockBuilder(CustomerInterfaceFactory::class)->disableOriginalConstructor()->getMock();
        $dataObjectProcessorMock = $this->getMockBuilder(DataObjectProcessor::class)->disableOriginalConstructor()->getMock();
        $dataObjectHelperMock = $this->getMockBuilder(DataObjectHelper::class)->disableOriginalConstructor()->getMock();
        $metadataServiceMock = $this->getMockBuilder(CustomerMetadataInterface::class)->getMockForAbstractClass();
        $indexerRegistryMock = $this->getMockBuilder(IndexerRegistry::class)->disableOriginalConstructor()->getMock();

        return new Customer(
            $contextMock,
            $registryMock,
            $storeManagerMock,
            $configMock,
            $scopeConfigMock,
            $resourceMock,
            $configShareMock,
            $addressFactoryMock,
            $addressesFactoryMock,
            $transportBuilderMock,
            $groupRepositoryMock,
            $encryptorMock,
            $dateTimeMock,
            $customerDataFactoryMock,
            $dataObjectProcessorMock,
            $dataObjectHelperMock,
            $metadataServiceMock,
            $indexerRegistryMock
        );
    }
}
