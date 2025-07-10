<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\UsersControl;

class UserProfilesWidget extends BaseGeneralWidget
{
    use UsersControl;

    public function getKey(): string
    {
        return 'user_profiles';
    }

    public function getName(): string
    {
        return tdf_admin_string('user_profiles');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addUsersControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addSocialIconsStyle();

        $this->addGridControls();

        $this->endControlsSection();
    }

    public function getSocialIconsStyle(): string
    {
        $style = $this->get_settings_for_display('social_icons_style');
        if (empty($style)) {
            return 'regular';
        }

        return $style;
    }

    public function smallerIcons(): bool
    {
        return $this->getSocialIconsStyle() === 'smaller';
    }

    private function addSocialIconsStyle(): void
    {
        $this->add_control(
            'social_icons_style',
            [
                'label' => esc_html__('Icons style', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'regular' => esc_html__('Regular', 'listivo-core'),
                    'smaller' => esc_html__('Smaller', 'listivo-core'),
                ],
                'default' => 'regular',
            ]
        );
    }

    private function addGridControls(): void
    {
        $this->add_responsive_control(
            'grid_columns',
            [
                'label' => esc_html__('Columns', 'listivo-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-profiles' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr))',
                ]
            ]
        );

        $this->add_responsive_control(
            'gap_columns',
            [
                'label' => esc_html__('Columns Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-profiles' => 'grid-column-gap: {{VALUE}}px'
                ]
            ]
        );

        $this->add_responsive_control(
            'gap_rows',
            [
                'label' => esc_html__('Rows Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-profiles' => 'grid-row-gap: {{VALUE}}px'
                ]
            ]
        );
    }
}