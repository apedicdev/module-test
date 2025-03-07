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

use Magento\Sales\Api\Data\{OrderExtensionInterface, OrderExtensionInterfaceFactory, OrderInterface};

readonly class OrderAttributesExtensionPlugin
{
    public function __construct(private OrderExtensionInterfaceFactory $orderExtensionInterfaceFactory)
    {
    }

    public function afterGetExtensionAttributes(
        OrderInterface $order,
        OrderExtensionInterface $orderExtension = null
    ): OrderExtensionInterface {
        return $orderExtension ?? $this->orderExtensionInterfaceFactory->create();
    }
}
