<?php

namespace Tangibledesign\Framework\Core;

use JsonException;
use Pimple\Container;
use Tangibledesign\Framework\Helpers\CurrentUserCan;
use WP_Post;

abstract class ServiceProvider
{
    use CurrentUserCan;

    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function initiation(): void
    {

    }

    public function afterInitiation(): void
    {

    }

    /**
     * @param $params
     * @return void
     * @throws JsonException
     */
    public function jsonResponse($params): void
    {
        echo json_encode($params, JSON_THROW_ON_ERROR);
    }

    /**
     * @param array $params
     * @return void
     */
    public function successJsonResponse(array $params = []): void
    {
        /** @noinspection JsonEncodingApiUsageInspection */
        echo json_encode($params + [
                'success' => true,
            ]);
    }

    /**
     * @param array $params
     * @return void
     */
    public function errorJsonResponse(array $params = []): void
    {
        /** @noinspection JsonEncodingApiUsageInspection */
        echo json_encode($params + [
                'success' => false,
            ]);
    }

    /**
     * @return bool
     */
    protected function isComparePage(): bool
    {
        global $post;
        return $post instanceof WP_Post && tdf_settings()->getComparePageId() === $post->ID;
    }

    protected function canManageOptions(): bool
    {
        return current_user_can('manage_options');
    }
}