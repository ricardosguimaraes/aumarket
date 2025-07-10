<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;


trait CardTypeControl
{
    use Control;

    protected function addCardTypeControl(): void
    {
        $this->add_control(
            'card_type',
            [
                'label' => esc_html__('Card Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'regular' => esc_html__('Regular', 'listivo-core'),
                    'simple' => esc_html__('Simple', 'listivo-core'),
                ],
                'default' => 'regular',
            ]
        );
    }

    public function getCardType(): string
    {
        $type = $this->get_settings_for_display('card_type');

        if (empty($type)) {
            return 'regular';
        }

        return $type;
    }

    public function loadCard(): void
    {
        get_template_part('templates/partials/card/listing_card_v3');
    }

}