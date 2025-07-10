<?php

namespace Tangibledesign\Framework\Providers\Orders;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\Order;

class DeleteOrderServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/order/delete', [$this, 'deleteOrder']);
    }

    public function deleteOrder(): void
    {
        $currentUser = tdf_current_user();
        if (!$currentUser || !$currentUser->isModerator()) {
            $this->errorJsonResponse();
            return;
        }

        $order = $this->fetchOrder();
        if (!$order) {
            $this->errorJsonResponse();
            return;
        }

        $order->delete();

        $this->successJsonResponse();
    }

    private function fetchOrder(): ?Order
    {
        $orderId = (int)($_POST['orderId'] ?? 0);
        if (empty($orderId)) {
            return null;
        }

        return tdf_order_factory()->create($orderId);
    }
}