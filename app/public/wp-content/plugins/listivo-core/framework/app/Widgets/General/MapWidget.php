<?php


namespace Tangibledesign\Framework\Widgets\General;


use Elementor\Controls_Manager;
use Exception;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

/**
 * Class MapWidget
 * @package Tangibledesign\Framework\Widgets\General
 */
class MapWidget extends BaseGeneralWidget
{
    public const ADDRESS = 'address';
    public const LAT = 'lat';
    public const LNG = 'lng';
    public const ZOOM = 'zoom';

    /**
     * MapWidget constructor.
     * @param array $data
     * @param null $args
     * @throws Exception
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->registerMapDeps();
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'map';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('map');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLocationControls();

        $this->addZoomControl();

        $this->addHeightControl();

        $this->endControlsSection();
    }

    protected function addLocationControls(): void
    {
        $this->add_control(
            self::LAT,
            [
                'label' => tdf_admin_string('lat'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            self::LNG,
            [
                'label' => tdf_admin_string('lng'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    protected function addZoomControl(): void
    {
        $this->add_control(
            self::ZOOM,
            [
                'label' => tdf_admin_string('zoom'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
            ]
        );
    }

    protected function addHeightControl(): void
    {
        $this->add_responsive_control(
            'height',
            [
                'label' => tdf_admin_string('height'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 640,
                ],
                'range' => [
                    'px' => [
                        'min' => 40,
                        'max' => 1440,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-map' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    }

    /**
     * @return int
     */
    public function getZoom(): int
    {
        $data = $this->get_settings_for_display(self::ZOOM);
        return isset($data['size']) ? (int)$data['size'] : 10;
    }

    /**
     * @return double
     */
    public function getLat(): float
    {
        return (double)$this->get_settings_for_display(self::LAT);
    }

    /**
     * @return double
     */
    public function getLng(): float
    {
        return (double)$this->get_settings_for_display(self::LNG);
    }

    /**
     * @return float[]
     */
    public function getPosition(): array
    {
        return [
            'lat' => $this->getLat(),
            'lng' => $this->getLng(),
        ];
    }

    /**
     * @return array
     */
    public function get_script_depends(): array
    {
        return $this->getMapScriptDeps();
    }

    /**
     * @return array
     */
    public function get_style_depends(): array
    {
        return $this->getMapStyleDeps();
    }

    /**
     * @return string
     */
    public function getMarkerType(): string
    {
        return 'classic';
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        $icon = $this->get_settings_for_display('icon');

        return $icon['url'] ?? '';
    }

}