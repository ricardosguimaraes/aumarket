<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\OrderStatus;

class MyOrdersServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/panel/user/orders', [$this, 'orders']);
    }

    public function orders(): void
    {
        if (!is_user_logged_in() || !tdf_settings()->paymentsEnabled()) {
            return;
        }

        /** @noinspection JsonEncodingApiUsageInspection */
        /** @noinspection NullPointerExceptionInspection */
        echo json_encode([
            'template' => $this->getTemplate(),
            'count' => tdf_current_user()->getOrdersNumber($this->getStatus()),
            'page' => $this->getPage(),
        ]);
    }

    private function getTemplate(): string
    {
        ob_start();

        global ${tdf_short_prefix() . 'CurrentOrder'};
        foreach ($this->getOrders() as ${tdf_short_prefix() . 'CurrentOrder'}) {
            get_template_part('templates/widgets/general/panel/my_order');
        }

        return ob_get_clean();
    }

    private function getOrders(): Collection
    {
        /** @noinspection NullPointerExceptionInspection */
        $query = tdf_query_orders()
            ->userIn(tdf_current_user()->getId())
            ->setPage($this->getPage())
            ->take(10);

        if ($this->getStatus() !== 'any') {
            $query->where('status', $this->getStatus());
        }

        return $query->get();
    }

    private function getStatus(): string
    {
        $status = (string)($_POST['status'] ?? '');
        if (!in_array($status, OrderStatus::all())) {
            return 'any';
        }

        return $status;
    }

    private function getPage(): int
    {
        $page = (int)($_POST['page'] ?? 1);
        if ($page < 1) {
            return 1;
        }

        return $page;
    }

}