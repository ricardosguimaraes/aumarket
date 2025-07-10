<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetHomepage
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetHomepage
{
    use Setting;

    /**
     * @param int $pageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setHomepage($pageId): void
    {
        $pageId = (int)$pageId;

        $this->setSetting(SettingKey::HOMEPAGE, $pageId);

        if (!empty($pageId)) {
            update_option('page_on_front', $pageId);
            update_option('show_on_front', 'page');
        }
    }

    /**
     * @return int
     */
    public function getHomepageId(): int
    {
        return (int)$this->getSetting(SettingKey::HOMEPAGE);
    }

}