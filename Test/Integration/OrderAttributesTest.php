<?php
/**
 * Apedik_test
 *
 * @author    Antonio Pedicini <me@apedik.dev>
 * @website   https://apedik.dev
 *
 */

declare(strict_types=1);

namespace Apedik\Test\Test\Integration;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Model\OrderRepository;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class OrderAttributesTest extends TestCase
{
    private ?OrderRepository $orderRepository = null;
    private ?SearchCriteriaBuilder $searchCriteriaBuilder = null;

    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();

        $this->orderRepository = $objectManager->get(OrderRepositoryInterface::class);
        $this->searchCriteriaBuilder = $objectManager->get(SearchCriteriaBuilder::class);
    }

    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testOrderSaveAndAttributePopulation(): void
    {
        // Get an order
        $searchCriteria = $this->searchCriteriaBuilder->setPageSize(1)->create();
        $orders = $this->orderRepository->getList($searchCriteria)->getItems();
        $order = current($orders);

        $orderId = $order->getEntityId();

        $extensionAttributes = $this->orderRepository->get($orderId)->getExtensionAttributes();

        $this->assertNotNull($extensionAttributes);

        $this->assertEquals(
            $order->getCustomerEmail(),
            $extensionAttributes->getCustomAttribute1(),
            'custom_attribute_1 is not populated correctly'
        );

        $this->assertEquals(
            $order->getTotalQtyOrdered(),
            $extensionAttributes->getCustomAttribute2(),
            'custom_attribute_2 is not populated correctly'
        );

        $complexAttributeValue = sprintf(
            '%s_%s',
            $order->getCustomerGroupId(),
            $order->getStatus()
        );

        $this->assertEquals(
            $complexAttributeValue,
            $extensionAttributes->getComplexAttribute(),
            'complex_attribute is not populated correctly'
        );
    }
}
