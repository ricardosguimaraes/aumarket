<?php

namespace Tangibledesign\Framework\Models\User\Helpers;

use Tangibledesign\Framework\Models\Helpers\HasMeta;

trait HasSocialSource
{
    use HasMeta;

    /**
     * @param int $isSocialSource
     */
    public function setSocialSource(int $isSocialSource): void
    {
        $this->setMeta(UserSettingKey::SOCIAL_SOURCE, $isSocialSource);
    }

    /**
     * @return bool
     */
    public function isSocialSource(): bool
    {
        return !empty($this->getMeta(UserSettingKey::SOCIAL_SOURCE));
    }

}