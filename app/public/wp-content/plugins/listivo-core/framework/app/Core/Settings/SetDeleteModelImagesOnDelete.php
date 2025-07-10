<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetDeleteModelImagesOnDelete
{
    use Setting;

    public function setDeleteModelImagesOnDelete($delete): void
    {
        $this->setSetting(SettingKey::DELETE_MODEL_IMAGES_ON_DELETE, (int)$delete);
    }

    public function deleteModelImagesOnDelete(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::DELETE_MODEL_IMAGES_ON_DELETE));
    }
}