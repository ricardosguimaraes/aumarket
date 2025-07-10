<?php

namespace Tangibledesign\Framework\Providers\Panel;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\Order;
use Tangibledesign\Framework\Models\Payments\OrderStatus;
use Tangibledesign\Framework\Models\Post\PostStatus;
use WP_Query;

class PanelOrdersServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/panel/orders', [$this, 'orders']);
    }

    public function orders(): void
    {
        /** @noinspection NullPointerExceptionInspection */
        if (!tdf_current_user()->canSeeOrders() || !tdf_settings()->paymentsEnabled()) {
            return;
        }

        /** @noinspection JsonEncodingApiUsageInspection */
        echo json_encode([
            'template' => $this->getTemplate(),
            'count' => $this->getOrderCountByStatus($this->getStatus()),
            'page' => $this->getPage(),
            'countByStatus' => $this->getOrderCountByStatuses(),
        ]);
    }

    private function getTemplate(): string
    {
        ob_start();

        global ${tdf_short_prefix() . 'CurrentOrder'};

        foreach ($this->getOrders() as ${tdf_short_prefix() . 'CurrentOrder'}) {
            get_template_part('templates/widgets/general/panel/order');
        }

        return ob_get_clean();
    }

    private function getOrderCountByStatuses(): array
    {
        $data = [
            'any' => $this->getOrderCountByStatus('any')
        ];

        foreach (OrderStatus::all() as $status) {
            $data[$status] = $this->getOrderCountByStatus($status);
        }

        return $data;
    }

    private function getOrderCountByStatus(string $status): int
    {
        $args = $this->getQueryOrdersArgs();
        if (!$args) {
            return 0;
        }

        $args = [
                'posts_per_page' => -1,
                'status' => PostStatus::PUBLISH,
                'return' => 'ids',
                'post_type' => tdf_prefix() . '_order',
            ] + $args;

        if ($status !== 'any') {
            $args['meta_query'] = [
                [
                    'key' => 'status',
                    'value' => $status,
                ]
            ];
        } else {
            unset($args['meta_query']);
        }

        return (new WP_Query($args))->found_posts;
    }

    /**
     * @return Collection|Order[]
     */
    private function getOrders(): Collection
    {
        $args = $this->getQueryOrdersArgs();
        if (!$args) {
            return tdf_collect();
        }

        return tdf_collect((new WP_Query($args))->posts)
            ->map(static function ($post) {
                return tdf_order_factory()->create($post);
            })->filter(static function ($order) {
                return $order instanceof Order;
            });
    }

    /**
     * @return array|false
     */
    private function getQueryOrdersArgs()
    {
        $keyword = $this->getKeyword();
        $orderIds = $this->getOrderIds($keyword);

        if (!empty($keyword) && empty($orderIds)) {
            return false;
        }

        $args = [
            'paged' => $this->getPage(),
            'posts_per_page' => 10,
            'post_type' => tdf_prefix() . '_order',
            'post_status' => PostStatus::PUBLISH,
            'meta_query' => [
                [
                    'key' => 'status',
                    'value' => $this->getStatus(),
                ]
            ],
        ];

        if ($this->getStatus() === 'any') {
            unset($args['meta_query']);
        }

        if (!empty($keyword)) {
            $args['post__in'] = $orderIds;
        }

        return $args;
    }

    private function getStatus(): string
    {
        $status = (string)($_POST['status'] ?? '');
        if (!in_array($status, OrderStatus::all(), true)) {
            return 'any';
        }

        return $status;
    }

    private function getKeyword(): string
    {
        return (string)($_POST['keyword'] ?? '');
    }

    private function getPage(): int
    {
        $page = (int)($_POST['page'] ?? 1);
        if ($page < 1) {
            return 1;
        }

        return $page;
    }

    private function getOrderIds(string $keyword): array
    {
        $orderIds = $this->getOrderIdsByUsers($keyword);

        foreach (tdf_query_orders()->in((int)$keyword)->get() as $order) {
            /* @var Order $order */
            $orderIds[] = $order->getId();
        }

        return $orderIds;
    }

    private function getOrderIdsByUsers(string $keyword): array
    {
        $userIds = $this->getUserIds($keyword);
        if (empty($userIds)) {
            return [];
        }

        $orders = tdf_query_orders()
            ->userIn($userIds)
            ->get();

        if ($orders->isEmpty()) {
            return [];
        }

        return $orders->map(static function ($order) {
            /* @var Order $order */
            return $order->getId();
        })->values();
    }

    private function getUserIds(string $keyword): array
    {
        return tdf_query_users()
            ->keyword($keyword)
            ->get()
            ->map(static function ($user) {
                return $user->getId();
            })
            ->values();
    }

}