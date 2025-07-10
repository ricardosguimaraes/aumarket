<?php

namespace Tangibledesign\Framework\Providers\Orders;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\Order;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

class OrderStatusServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/order/status', [$this, 'setStatus']);
    }

    public function setStatus(): void
    {
        /** @noinspection NullPointerExceptionInspection */
        if (!tdf_current_user()->canSeeOrders()) {
            return;
        }

        $order = $this->getOrder();
        if (!$order) {
            return;
        }

        $order->setStatus($this->getStatus());

        wp_safe_redirect(PanelWidget::getUrl(PanelWidget::ACTION_ORDERS));
        exit;
    }

    private function getStatus(): string
    {
        return $_GET['status'] ?? '';
    }

    private function getOrder(): ?Order
    {
        $orderId = (int)$_GET['orderId'];
        if (empty($orderId)) {
            return null;
        }

        return tdf_order_factory()->create($orderId);
    }
}