<?php


namespace Tangibledesign\Framework\Models\Template\Helpers;


use Elementor\Core\Base\Document;

/**
 * Trait HasTransparentMenu
 * @package Tangibledesign\Framework\Models\Template\Helpers
 */
trait HasTransparentMenu
{
    /**
     * @return Document|false
     */
    abstract public function getDocument();

    /**
     * @return bool
     */
    public function hasTransparentMenu(): bool
    {
        return !empty((int)$this->getDocument()->get_settings('tdf_transparent_menu'));
    }

    /**
     * @param int $enabled
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setTransparentMenu($enabled): void
    {
        $this->getDocument()->update_settings([
            'tdf_layout' => !empty($enabled),
        ]);
    }

}