<?php


namespace Tangibledesign\Framework\Core\Settings;


use Tangibledesign\Framework\Models\Image;

/**
 * Trait SetLogo
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetLogo
{
    use Setting;

    /**
     * @param int $imageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setLogo($imageId): void
    {
        $this->setSetting(SettingKey::LOGO, (int)$imageId);
    }

    /**
     * @return int
     */
    public function getLogoId(): int
    {
        return (int)$this->getSetting(SettingKey::LOGO);
    }

    /**
     * @param int $imageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setInverseLogo($imageId): void
    {
        $this->setSetting(SettingKey::INVERSE_LOGO, $imageId);
    }

    /**
     * @return int
     */
    public function getInverseLogoId(): int
    {
        return (int)$this->getSetting(SettingKey::INVERSE_LOGO);
    }

    /**
     * @return Image|false
     */
    public function getLogo()
    {
        $logoId = $this->getLogoId();
        if (empty($logoId)) {
            return false;
        }

        return tdf_image_factory()->create($logoId);
    }

    /**
     * @return Image|false
     */
    public function getInverseLogo()
    {
        $inverseLogoId = $this->getInverseLogoId();
        if (empty($inverseLogoId)) {
            return $this->getLogo();
        }

        return tdf_image_factory()->create($inverseLogoId);
    }

}