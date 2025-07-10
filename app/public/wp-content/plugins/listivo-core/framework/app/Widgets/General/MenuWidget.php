<?php

namespace Tangibledesign\Framework\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\MenuControl;

abstract class MenuWidget extends BaseGeneralWidget
{
    use MenuControl;

    public const LOGO_TYPE = 'logo_type';
    public const LOGO_TYPE_STANDARD = 'standard';
    public const LOGO_TYPE_INVERSE = 'inverse';
    public const LOGO_TYPE_SAME = 'same';
    public const STICKY_LOGO_TYPE = 'sticky_logo_type';
    public const CTA_BUTTON_ICON = 'cta_button_icon';

    protected function addContentControls(): void
    {
        $this->addMenuControl();

        $this->addLogoControls();

        $this->addCtaButtonIconControl();
    }

    public function getCtaButtonUrl(): string
    {
        $ctaButtonUrl = tdf_settings()->getMenuCtaButtonUrl();
        if (empty($ctaButtonUrl)) {
            return $this->getDefaultCtaButtonUrl();
        }

        return $ctaButtonUrl;
    }

    protected function getDefaultCtaButtonUrl(): string
    {
        if (is_user_logged_in() || tdf_settings()->submitWithoutLogin()) {
            return site_url() . '/' . tdf_slug('panel') . '/' . tdf_slug(PanelWidget::ACTION_CREATE) . '/';
        }

        return tdf_settings()->getLoginPageUrlWithoutTab();
    }

    protected function addLogoControls(): void
    {
        $this->add_control(
            self::LOGO_TYPE,
            [
                'label' => tdf_admin_string('logo'),
                'type' => Controls_Manager::SELECT,
                'default' => self::LOGO_TYPE_STANDARD,
                'options' => [
                    self::LOGO_TYPE_STANDARD => tdf_admin_string('standard'),
                    self::LOGO_TYPE_INVERSE => tdf_admin_string('inverse'),
                ],
            ]
        );

        $this->add_control(
            self::STICKY_LOGO_TYPE,
            [
                'label' => tdf_admin_string('logo_sticky'),
                'type' => Controls_Manager::SELECT,
                'default' => self::LOGO_TYPE_SAME,
                'options' => [
                    self::LOGO_TYPE_SAME => tdf_admin_string('the_same'),
                    self::LOGO_TYPE_STANDARD => tdf_admin_string('standard'),
                    self::LOGO_TYPE_INVERSE => tdf_admin_string('inverse'),
                ],
            ]
        );
    }

    protected function addCtaButtonIconControl(): void
    {
        $this->add_control(
            self::CTA_BUTTON_ICON,
            [
                'label' => tdf_admin_string('cta_button_icon'),
                'type' => Controls_Manager::ICONS,
            ]
        );
    }

    public function hasCtaButtonIcon(): bool
    {
        return $this->getCtaButtonIcon() !== '';
    }

    public function getCtaButtonIcon(): string
    {
        $icon = $this->get_settings_for_display(self::CTA_BUTTON_ICON);

        if (empty($icon['value'])) {
            return '';
        }

        return $icon['value'];
    }

    public function hasLogo(): bool
    {
        return $this->getLogo() !== false;
    }

    /**
     * @return Image|false
     */
    public function getLogo()
    {
        $logoType = (string)$this->get_settings_for_display(self::LOGO_TYPE);
        if ($logoType === self::LOGO_TYPE_STANDARD) {
            return tdf_settings()->getLogo();
        }

        return tdf_settings()->getInverseLogo();
    }

    public function getLogoUrl(string $size = 'full'): string
    {
        $logo = $this->getLogo();
        if (!$logo) {
            return '';
        }

        return $logo->getImageUrl($size);
    }

    /**
     * @return Image|false
     */
    public function getStickyLogo()
    {
        $logoType = (string)$this->get_settings_for_display(self::STICKY_LOGO_TYPE);
        if ($logoType === self::LOGO_TYPE_SAME) {
            return $this->getLogo();
        }

        if ($logoType === self::LOGO_TYPE_STANDARD) {
            return tdf_settings()->getLogo();
        }

        return tdf_settings()->getInverseLogo();
    }

    public function getStickyLogoUrl(string $size = 'full'): string
    {
        $stickyLogo = $this->getStickyLogo();
        if (!$stickyLogo) {
            return '';
        }

        return $stickyLogo->getImageUrl($size);
    }
}