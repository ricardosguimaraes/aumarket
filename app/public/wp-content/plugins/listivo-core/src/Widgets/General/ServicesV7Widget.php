<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ImageControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class ServicesV7Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use ButtonControls;
    use ImageControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'services_v7';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Services V7', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addImageControl();

        $this->addHeadingControls();

        $this->addButtonControls();

        $this->addAddServicesControl();

        $this->endControlsSection();

        $this->addHeadingStyleSection();
    }

    private function addAddServicesControl(): void
    {
        $services = new Repeater();

        $services->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $services->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $services->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'services',
            [
                'label' => esc_html__('Services', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $services->get_controls(),
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getServices(): Collection
    {
        $services = $this->get_settings_for_display('services');
        if (empty($services) || !is_array($services)) {
            return tdf_collect();
        }

        return tdf_collect($services);
    }

}