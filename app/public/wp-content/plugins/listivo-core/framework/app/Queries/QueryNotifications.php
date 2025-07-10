<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\NotificationFactory;
use Tangibledesign\Framework\Models\Notification\Notification;

class QueryNotifications extends QueryPosts
{
    /** @var string */
    protected string $postType = 'notify';

    /** @var bool */
    protected bool $prefixPostType = true;

    /**
     * @param  string  $trigger
     * @return QueryNotifications
     */
    public function trigger(string $trigger): QueryNotifications
    {
        $this->metaQuery[] = [
            'key' => Notification::TRIGGER,
            'value' => $trigger,
        ];

        return $this;
    }

    protected function getFactory(): NotificationFactory
    {
        return new NotificationFactory();
    }
}