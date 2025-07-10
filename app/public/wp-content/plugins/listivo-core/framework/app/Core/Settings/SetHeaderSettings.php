<?php


namespace Tangibledesign\Framework\Core\Settings;


use Tangibledesign\Framework\Models\Page;

/**
 * Trait SetHeaderSettings
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetHeaderSettings
{
    use Setting;

    /**
     * @param int $menuId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMainMenu($menuId): void
    {
        $this->setSetting(SettingKey::MAIN_MENU, $menuId);
    }

    /**
     * @return int
     */
    public function getMainMenuId(): int
    {
        return (int)$this->getSetting(SettingKey::MAIN_MENU);
    }

    /**
     * @param int $isSticky
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setStickyMainMenu($isSticky): void
    {
        $this->setSetting(SettingKey::STICKY_MAIN_MENU, !empty($isSticky));
    }

    /**
     * @return bool
     */
    public function isMainMenuSticky(): bool
    {
        return !empty($this->getSetting(SettingKey::STICKY_MAIN_MENU));
    }

    /**
     * @param int $show
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setShowMenuCtaButton($show): void
    {
        $this->setSetting(SettingKey::SHOW_MENU_CTA_BUTTON, (int)$show);
    }

    /**
     * @return bool
     */
    public function showMenuCtaButton(): bool
    {
        return !empty($this->getSetting(SettingKey::SHOW_MENU_CTA_BUTTON));
    }

    /**
     * @param int $pageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMenuCtaButtonPage($pageId): void
    {
        $this->setSetting(SettingKey::MENU_CTA_BUTTON_PAGE, (int)$pageId);
    }

    /**
     * @return int
     */
    public function getMenuCtaButtonPageId(): int
    {
        return (int)$this->getSetting(SettingKey::MENU_CTA_BUTTON_PAGE);
    }

    /**
     * @return string
     */
    public function getMenuCtaButtonUrl(): string
    {
        $pageId = $this->getMenuCtaButtonPageId();
        if (empty($pageId)) {
            return '';
        }

        if ($pageId === -1) {
            return get_post_type_archive_link(tdf_model_post_type());
        }

        $page = tdf_post_factory()->create($pageId);
        if (!$page instanceof Page) {
            return '';
        }

        return $page->getUrl();
    }

    /**
     * @param int $show
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setShowMenuAccount($show): void
    {
        $this->setSetting(SettingKey::SHOW_MENU_ACCOUNT, (int)$show);
    }

    /**
     * @return bool
     */
    public function showMenuAccount(): bool
    {
        return !empty($this->getSetting(SettingKey::SHOW_MENU_ACCOUNT));
    }

    /**
     * @param string $text
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setCustomMenuCtaText($text): void
    {
        $this->setSetting(SettingKey::CUSTOM_MENU_CTA_TEXT, (string)$text);
    }

    /**
     * @return string
     */
    public function getCustomMenuCtaText(): string
    {
        return (string)$this->getSetting(SettingKey::CUSTOM_MENU_CTA_TEXT);
    }

}