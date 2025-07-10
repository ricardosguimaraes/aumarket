<?php

namespace Tangibledesign\Framework\Core\Settings;

use Tangibledesign\Framework\Models\Model;

trait SetMessageSystemInitialMessage
{
    use Setting;

    public function setMessageSystemInitialMessage($message): void
    {
        $this->setSetting(SettingKey::MESSAGE_SYSTEM_INITIAL_MESSAGE, $message);
    }

    public function getMessageSystemInitialMessageOption(): string
    {
        return (string)$this->getSetting(SettingKey::MESSAGE_SYSTEM_INITIAL_MESSAGE);
    }

    public function getMessageSystemInitialMessage(Model $model): string
    {
        $message = $this->getSetting(SettingKey::MESSAGE_SYSTEM_INITIAL_MESSAGE);
        if (empty($message)) {
            return tdf_string('i_m_interested_in') . ' ' . $model->getName();
        }

        $search = ['{listingName}', '{listingPrice}', '{listingAddress}', '{listingId}', '{listingUrl}'];
        $replace = [$model->getName(), $model->getPrice(), $model->getAddress(), $model->getId(), $model->getUrl()];

        return str_replace($search, $replace, $message);
    }
}