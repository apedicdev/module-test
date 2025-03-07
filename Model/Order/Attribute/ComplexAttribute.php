<?php
/**
 * Apedik_test
 *
 * @author    Antonio Pedicini <me@apedik.dev>
 * @website   https://apedik.dev
 *
 */

declare(strict_types=1);

namespace Apedik\Test\Model\Order\Attribute;

use Magento\Sales\Api\Data\OrderInterface;
use Apedik\Test\Api\OrderAttributeHydratorInterface;

class ComplexAttribute implements OrderAttributeHydratorInterface
{
    public function hydrate(OrderInterface $order)
    {
        // Example: Combine customer group ID and order status
        return sprintf("%s_%s", $order->getCustomerGroupId(), $order->getStatus());
    }
}
