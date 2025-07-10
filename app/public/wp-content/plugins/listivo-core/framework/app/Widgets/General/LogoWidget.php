<?php

namespace Tangibledesign\Framework\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\AlignmentControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\FlexAlignmentControl;

class LogoWidget extends BaseGeneralWidget
{
    use FlexAlignmentControl;

    public function getKey(): string
    {
        return 'logo';
    }

    public function getName(): string
    {
        return tdf_admin_string('logo');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTypeControl();

        $this->addIsLinkControl();

        $this->addFlexAlignmentControl('.' . tdf_prefix() . '-image-wrapper');

        $this->addHeightControl();

        $this->addImageSizeControl();

        $this->endControlsSection();
    }

    private function addTypeControl(): void
    {
        $this->add_control(
            'type',
            [
                'label' => tdf_admin_string('type'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => tdf_admin_string('default'),
                    'inverse' => tdf_admin_string('inverse'),
                ],
                'default' => 'default',
            ]
        );
    }

    private function addHeightControl(): void
    {
        $this->add_responsive_control(
            'height',
            [
                'label' => tdf_admin_string('height'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-image-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
    }

    private function addImageSizeControl(): void
    {
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'size',
                'exclude' => ['custom'],
                'label' => tdf_admin_string('size'),
                'default' => 'full',
            ]
        );
    }

    /**
     * @return Image|false
     */
    public function getLogo()
    {
        $type = $this->getType();
        if ($type === 'inverse') {
            return $this->getInverseLogo();
        }

        return $this->getDefaultLogo();
    }

    /**
     * @return Image|false
     */
    private function getDefaultLogo()
    {
        return tdf_post_factory()->create(tdf_settings()->getLogoId());
    }

    /**
     * @return Image|false
     */
    private function getInverseLogo()
    {
        $logo = tdf_post_factory()->create(tdf_settings()->getInverseLogoId());
        if (!$logo) {
            return $this->getDefaultLogo();
        }

        return $logo;
    }

    private function getType(): string
    {
        $type = $this->get_settings_for_display('type');
        if (empty($type)) {
            return 'default';
        }

        return $type;
    }

    public function getImageSize(): string
    {
        return $this->get_settings_for_display('size_size');
    }


    private function addIsLinkControl(): void
    {
        $this->add_control(
            'is_link',
            [
                'label' => tdf_admin_string('is_link'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function isLink(): bool
    {
        return !empty((int)$this->get_settings_for_display('is_link'));
    }
}