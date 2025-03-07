<?php
/**
 * Apedik_test
 *
 * @author    Antonio Pedicini <me@apedik.dev>
 * @website   https://apedik.dev
 *
 */

declare(strict_types=1);

namespace Apedik\Test\Plugin\Sales\Model\Order;

use Magento\Sales\Api\Data\{OrderExtensionInterface, OrderInterface, OrderSearchResultInterface};
use Magento\Sales\Api\OrderRepositoryInterface;
use Apedik\Test\Api\OrderAttributeHydratorInterface;

/**
 * Plugin for adding extensions attributes to OrderInterface.
 *
 * The OrderAttributesPlugin class is responsible for setting extension attributes
 * on order objects. It uses a list of custom attributes, which can either be objects
 * implementing OrderAttributesLoadInterface or simple data types. This plugin modifies
 * the order’s extension attributes post-save, post-retrieval, and in bulk retrievals.
 *
 */
readonly class OrderAttributesPlugin
{

    public function __construct(private array $attributes = [])
    {
    }

    public function afterSave(OrderRepositoryInterface $subject, OrderInterface $order): array
    {
        $this->setAttributes($order);

        return [$order];
    }

    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order): OrderInterface
    {
        $this->setAttributes($order, $order->getExtensionAttributes());
        return $order;
    }

    public function afterGetList(
        OrderRepositoryInterface $subject,
        OrderSearchResultInterface $orders
    ): OrderSearchResultInterface {
        foreach ($orders->getItems() as $order) {
            $this->setAttributes($order, $order->getExtensionAttributes());
        }

        return $orders;
    }

    /**
     * Sets attributes on the provided OrderInterface or OrderExtensionInterface object.
     *
     * This method iterates through the attributes, in di.xml, array and assigns each attribute value
     * If an attribute value implements OrderAttributesLoadInterface it loads it using the interface’s load method.
     * Otherwise, it retrieves the attribute value directly from the order data.
     *
     * @param OrderInterface $order The order item to which extension attributes are added.
     * @return void
     */
    private function setAttributes(OrderInterface $order): void
    {
        foreach ($this->attributes as $attributeCode => $attributeValue) {
            $value = $attributeValue instanceof OrderAttributeHydratorInterface
                ? $attributeValue->hydrate($order)
                : $order->getData($attributeValue);

            $order->getExtensionAttributes()->setData($attributeCode, $value);
        }
    }
}
