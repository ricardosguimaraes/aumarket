<?php


namespace Tangibledesign\Framework\Core\Settings;


use Tangibledesign\Framework\Models\Page;
use WP_Post;

/**
 * Trait SetPages
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetPages
{
    use Setting;

    /**
     * @param array $pageIds
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setAdditionalSearchPages($pageIds): void
    {
        $this->setSetting(SettingKey::ADDITIONAL_SEARCH_PAGES, $pageIds);
    }

    /**
     * @return array
     */
    public function getAdditionalSearchPagesIds(): array
    {
        $ids = $this->getSetting(SettingKey::ADDITIONAL_SEARCH_PAGES);
        if (!is_array($ids) || empty($ids)) {
            return [];
        }

        return tdf_collect($ids)->map(static function ($id) {
            return (int)$id;
        })->values();
    }

    /**
     * @param int $pageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setPanelPage($pageId): void
    {
        $this->setSetting(SettingKey::PANEL_PAGE, (int)$pageId);
    }

    /**
     * @return int
     */
    public function getPanelPageId(): int
    {
        return (int)$this->getSetting(SettingKey::PANEL_PAGE);
    }

    /**
     * @return string
     */
    public function getPanelPageUrl(): string
    {
        $pageId = $this->getPanelPageId();
        if (empty($pageId)) {
            return '';
        }

        $page = tdf_post_factory()->create($pageId);
        if (!$page instanceof Page) {
            return '';
        }

        return $page->getUrl();
    }

    /**
     * @param int $pageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setLoginPage($pageId): void
    {
        $this->setSetting(SettingKey::LOGIN_PAGE, (int)$pageId);
    }

    /**
     * @return int
     */
    public function getLoginPageId(): int
    {
        return (int)$this->getSetting(SettingKey::LOGIN_PAGE);
    }

    /**
     * @return string
     */
    public function getLoginPageUrlWithoutTab(): string
    {
        $pageId = $this->getLoginPageId();
        if (empty($pageId)) {
            return '';
        }

        $page = tdf_post_factory()->create($pageId);
        if (!$page instanceof Page) {
            return '';
        }

        return $page->getUrl();
    }

    /**
     * @return string
     */
    public function getLoginPageUrl(): string
    {
        $pageId = $this->getLoginPageId();
        if (empty($pageId)) {
            return '';
        }

        $page = tdf_post_factory()->create($pageId);
        if (!$page instanceof Page) {
            return '';
        }

        return $page->getUrl() . '?' . tdf_slug('tab') . '=' . tdf_slug('login');
    }

    /**
     * @return bool
     */
    public function isLoginPageUrl(): bool
    {
        if (!is_page()) {
            return false;
        }

        global $post;
        /** @noinspection PhpMultipleClassDeclarationsInspection */
        if (!$post instanceof WP_Post) {
            return false;
        }

        return $post->ID === $this->getLoginPageId();
    }

    /**
     * @param int $pageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setRegisterPage($pageId): void
    {
        $this->setSetting(SettingKey::REGISTER_PAGE, (int)$pageId);
    }

    /**
     * @return int
     */
    public function getRegisterPageId(): int
    {
        $pageId = (int)$this->getSetting(SettingKey::REGISTER_PAGE);
        if (empty($pageId)) {
            return $this->getLoginPageId();
        }

        return $pageId;
    }

    /**
     * @return string
     */
    public function getRegisterPageUrl(): string
    {
        $pageId = $this->getRegisterPageId();
        if (empty($pageId)) {
            return '';
        }

        $page = tdf_post_factory()->create($pageId);
        if (!$page instanceof Page) {
            return '';
        }

        if ($this->getLoginPageId() !== $this->getRegisterPageId()) {
            return $page->getUrl();
        }

        return $page->getUrl() . '?' . tdf_slug('tab') . '=' . tdf_slug('register');
    }

    /**
     * @param int $pageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setBlogPage($pageId): void
    {
        $pageId = (int)$pageId;
        if (empty($pageId)) {
            return;
        }

        update_option('page_for_posts', $pageId);
        update_option('show_on_front', 'page');
    }

    /**
     * @return int
     */
    public function getBlogPageId(): int
    {
        return (int)get_option('page_for_posts');
    }

    /**
     * @return string
     */
    public function getBlogPageUrl(): string
    {
        $pageId = $this->getBlogPageId();
        if (empty($pageId)) {
            return '';
        }

        $page = tdf_post_factory()->create($pageId);
        if (!$page instanceof Page) {
            return '';
        }

        return $page->getUrl();
    }

    /**
     * @param int $pageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setErrorPage($pageId): void
    {
        $this->setSetting(SettingKey::ERROR_PAGE, (int)$pageId);
    }

    /**
     * @return int
     */
    public function getErrorPageId(): int
    {
        return (int)$this->getSetting(SettingKey::ERROR_PAGE);
    }

    /**
     * @return string
     */
    public function getErrorPageUrl(): string
    {
        $pageId = $this->getErrorPageId();
        if (empty($pageId)) {
            return '';
        }

        $page = tdf_post_factory()->create($pageId);
        if (!$page instanceof Page) {
            return '';
        }

        return $page->getUrl();
    }

    /**
     * @param int $pageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setComparePage($pageId): void
    {
        $this->setSetting(SettingKey::COMPARE_PAGE, (int)$pageId);
    }

    /**
     * @return int
     */
    public function getComparePageId(): int
    {
        return (int)$this->getSetting(SettingKey::COMPARE_PAGE);
    }

    /**
     * @return string
     */
    public function getComparePageUrl(): string
    {
        $pageId = $this->getComparePageId();
        if (empty($pageId)) {
            return '';
        }

        $page = tdf_post_factory()->create($pageId);
        if (!$page instanceof Page) {
            return '';
        }

        return $page->getUrl();
    }

}