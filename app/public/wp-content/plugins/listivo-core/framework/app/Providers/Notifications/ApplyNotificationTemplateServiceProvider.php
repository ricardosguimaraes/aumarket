<?php

namespace Tangibledesign\Framework\Providers\Notifications;

use Tangibledesign\Framework\Core\ServiceProvider;

class ApplyNotificationTemplateServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_filter(tdf_prefix().'/notification/message', [$this, 'applyTemplate'], 10, 2);
    }

    public function applyTemplate(string $message, string $rawMessage): string
    {
        return $message;
    }

}