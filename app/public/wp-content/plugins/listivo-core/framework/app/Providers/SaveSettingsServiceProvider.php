<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\CurrentUserCan;

class SaveSettingsServiceProvider extends ServiceProvider
{
    use CurrentUserCan;

    public function afterInitiation(): void
    {
        add_action('tdf/settings/save', [$this, 'save'], 10, 2);
    }

    public function save(array $settingKeys, array $data): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        tdf_settings()->update($settingKeys, $data);
    }

}