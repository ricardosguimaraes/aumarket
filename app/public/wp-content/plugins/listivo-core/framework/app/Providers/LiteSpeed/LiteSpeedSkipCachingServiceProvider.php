<?php

namespace Tangibledesign\Framework\Providers\LiteSpeed;

use Tangibledesign\Framework\Core\ServiceProvider;

class LiteSpeedSkipCachingServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('wp', [$this, 'shouldSkipCaching']);
    }

    public function shouldSkipCaching(): void
    {
        $postId = $this->getPostId();
        if (!$postId) {
            return;
        }

        if (in_array($postId, $this->getPageIds(), true)) {
            do_action('litespeed_control_set_nocache', 'nocache due to page id');
        }
    }

    private function getPostId(): ?int
    {
        global $post;

        return $post->ID ?? null;
    }

    private function getPageIds(): array
    {
        return [
            tdf_settings()->getComparePageId(),
            tdf_settings()->getPanelPageId(),
            tdf_settings()->getLoginPageId(),
            tdf_settings()->getRegisterPageId(),
        ];
    }
}