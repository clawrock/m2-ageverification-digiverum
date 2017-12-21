<?php

namespace ClawRock\Digiverum\Test\Unit\Model\Transformer;

use ClawRock\Digiverum\Model\Transformer\Address;
use ClawRock\Digiverum\Model\Value\Address as AddressValue;
use ClawRock\MagentoTesting\TestCase;
use Magento\Directory\Model\Region;
use Magento\Directory\Model\ResourceModel\Region\Collection;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory;
use Magento\Framework\DataObject;

/**
 * @covers \ClawRock\Digiverum\Model\Transformer\Address
 */
class AddressTest extends TestCase
{
    /**
     * @var Region|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $regionMock;

    /**
     * @var Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $regionCollectionMock;

    /**
     * @var CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $regionCollectionFactoryMock;

    /**
     * @var Address
     */
    protected $transformer;

    protected function setUp()
    {
        $this->regionMock = $this->getMockBuilder(Region::class)
            ->setMethods(['getCode'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->regionCollectionMock = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->regionCollectionMock->method('addFieldToFilter')->willReturnSelf();

        $this->regionCollectionFactoryMock = $this->mockFactory(CollectionFactory::class, $this->regionCollectionMock);

        $this->transformer = $this->createObject(Address::class, [
            'regionCollectionFactory' => $this->regionCollectionFactoryMock,
        ]);
    }

    /**
     * @covers \ClawRock\Digiverum\Model\Transformer\Address::transform
     */
    public function testTransformer()
    {
        $this->regionCollectionMock->expects($this->once())->method('getFirstItem')->willReturn($this->regionMock);

        $this->regionMock->expects($this->once())->method('getCode')->willReturn('region');

        $address = $this->transformer->transform(new DataObject([
            Address::STREET_FIELD   => ['street1', 'street2'],
            Address::REGION_FIELD   => 'region',
            Address::CITY_FIELD     => 'city',
            Address::POSTCODE_FIELD => 'postcode',
        ]));

        $this->assertEquals([
            AddressValue::ADDRESS1_KEY => 'street1',
            AddressValue::ADDRESS2_KEY => 'street2',
            AddressValue::STATE_KEY    => 'region',
            AddressValue::CITY_KEY     => 'city',
            AddressValue::ZIP_KEY      => 'postcode',
        ], $address->toArray());
    }
}
