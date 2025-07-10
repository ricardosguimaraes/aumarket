<?php

namespace Tangibledesign\Framework\Widgets\User;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\BorderRadiusControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ImageSizeControl;
use Tangibledesign\Framework\Widgets\Helpers\PostSingleWidget;

class UserImageWidget extends BaseUserWidget implements PostSingleWidget
{
    use ImageSizeControl;
    use BorderRadiusControl;

    public function getKey(): string
    {
        return 'user_image';
    }

    public function getName(): string
    {
        return tdf_admin_string('user_image');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addImageWidthControl();

        $this->addImageSizeControl();

        $this->addBorderRadiusControl($this->getSelector());

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    protected function addImageWidthControl(): void
    {
        $this->add_responsive_control(
            'width',
            [
                'label' => tdf_admin_string('width'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . tdf_prefix() . '-user-image-control-size' => 'width: {{SIZE}}{{UNIT}}!important; height: {{SIZE}}{{UNIT}}!important;'
                ]
            ]
        );
    }

    private function getSelector(): string
    {
        return '.' . tdf_prefix() . '-user-image-control-size';
    }
}