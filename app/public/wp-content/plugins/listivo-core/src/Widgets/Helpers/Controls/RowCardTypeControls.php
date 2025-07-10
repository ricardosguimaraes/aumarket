<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;
use Tangibledesign\Listivo\Widgets\Helpers\CardType;

trait RowCardTypeControls
{
    use Control;

    protected function addRowCardTypeControls(): void
    {
        $this->add_control(
            'row_card_type',
            [
                'label' => esc_html__('Row card type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    CardType::ROW_REGULAR => esc_html__('V1', 'listivo-core'),
                    CardType::ROW_REGULAR_V2 => esc_html__('V2', 'listivo-core'),
                ],
                'default' => CardType::ROW_REGULAR,
            ]
        );
    }

    public function getRowCardType(): string
    {
        $type = $this->get_settings_for_display('row_card_type');
        if (empty($type)) {
            return CardType::ROW_REGULAR;
        }

        if (!in_array($type, [CardType::ROW_REGULAR, CardType::ROW_REGULAR_V2], true)) {
            return CardType::ROW_REGULAR;
        }

        return $type;
    }

    public function loadRowCardTemplate(): void
    {
        if ($this->isRowV2CardType()) {
            get_template_part('templates/partials/card/listing_row_v2');
            return;
        }

        get_template_part('templates/partials/card/listing_row');
    }

    public function isRowV1CardType(): bool
    {
        return $this->getRowCardType() === CardType::ROW_REGULAR;
    }

    public function isRowV2CardType(): bool
    {
        return $this->getRowCardType() === CardType::ROW_REGULAR_V2;
    }
}