<?php
/**
 * Apedik_test
 *
 * @author    Antonio Pedicini <me@apedik.dev>
 * @website   https://apedik.dev
 *
 */

declare(strict_types=1);

namespace Apedik\Test\Api;

use Magento\Sales\Api\Data\OrderInterface;

interface OrderAttributeHydratorInterface
{
    public function hydrate(OrderInterface $order);
}
