<?php

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
        $this->orderRepository = Bootstrap::getObjectManager()->get(OrderRepository::class);
        $this->searchCriteriaBuilder = Bootstrap::getObjectManager()->get(SearchCriteriaBuilder::class);
    }

    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testOrderSaveAndAttributePopulation(): void
    {
        // Get an order (replace with your fixture or order creation logic)
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $orders = $this->orderRepository->getList($searchCriteria)->getItems();
        $order = reset($orders);

        $orderId = $order->getEntityId();

        // Retrieve the order
        $retrievedOrder = $this->orderRepository->get($orderId);
        $extensionAttributes = $retrievedOrder->getExtensionAttributes();

        // Assertions
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

    // Implement other test methods for order retrieval, listing, etc.
}
