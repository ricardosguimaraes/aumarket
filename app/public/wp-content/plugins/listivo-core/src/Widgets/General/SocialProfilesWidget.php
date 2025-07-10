<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextAlignControl;

/**
 * Class SocialProfiles
 * @package Tangibledesign\Listivo\Widgets
 */
class SocialProfilesWidget extends BaseGeneralWidget
{
    use TextAlignControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'social_profiles';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Social Profiles', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextAlignControl('.' . tdf_prefix() . '-social-profiles');

        $this->addStyleControl();

        $this->endControlsSection();
    }

    protected function addStyleControl(): void
    {
        $this->add_control(
            'style',
            [
                'label' => esc_html__('Style', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'v1',
                'options' => [
                    'v1' => esc_html__('V1', 'listivo-core'),
                    'v2' => esc_html__('V2', 'listivo-core'),
                ]
            ]
        );
    }

    /**
     * @return string
     */
    public function getStyle(): string
    {
        $style = $this->get_settings_for_display('style');
        if (empty($style)) {
            return 'v1';
        }

        return (string)$style;
    }

    /**
     * @return bool
     */
    public function isStyleV2(): bool
    {
        return $this->getStyle() === 'v2';
    }

}