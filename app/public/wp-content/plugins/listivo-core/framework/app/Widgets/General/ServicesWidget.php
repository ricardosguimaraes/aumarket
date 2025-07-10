<?php


namespace Tangibledesign\Framework\Widgets\General;


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

/**
 * Class ServicesWidget
 * @package Tangibledesign\Framework\Widgets
 */
class ServicesWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'services';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('services');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addServicesControl();

        $this->endControlsSection();
    }

    protected function addServicesControl(): void
    {
        $services = new Repeater();

        $services->add_control(
            'image',
            [
                'label' => tdf_admin_string('image'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $services->add_control(
            'title',
            [
                'label' => tdf_admin_string('title'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $services->add_control(
            'text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'services',
            [
                'label' => tdf_admin_string('services'),
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

        return tdf_collect($services)->map(static function ($service) {
            $service['image'] = tdf_image_factory()->create((int)$service['image']['id']);

            return $service;
        });
    }

}