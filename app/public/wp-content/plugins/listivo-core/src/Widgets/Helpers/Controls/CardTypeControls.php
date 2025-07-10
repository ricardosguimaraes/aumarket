<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;
use Tangibledesign\Listivo\Widgets\Helpers\CardType;

trait CardTypeControls
{
    use Control;

    protected function addCardTypeControls(string $default = CardType::CARD_REGULAR): void
    {
        $this->add_control(
            'card_type',
            [
                'label' => esc_html__('Card type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    CardType::CARD_REGULAR => esc_html__('Regular', 'listivo-core'),
                    CardType::CARD_SMALL => esc_html__('Small', 'listivo-core'),
                ],
                'default' => $default,
            ]
        );
    }

    public function getCardType(): string
    {
        $type = $this->get_settings_for_display('card_type');
        if (empty($type)) {
            return CardType::CARD_REGULAR;
        }

        if (!in_array($type, [CardType::CARD_REGULAR, CardType::CARD_SMALL], true)) {
            return CardType::CARD_REGULAR;
        }

        return $type;
    }

    public function loadCardTemplate(): void
    {
        if ($this->getCardType() === CardType::CARD_SMALL) {
            get_template_part('templates/partials/card/listing_card_v4');
            return;
        }

        get_template_part('templates/partials/card/listing_card_v3');
    }

    public function isRegularCardType(): bool
    {
        return $this->getCardType() === CardType::CARD_REGULAR;
    }

    public function isSmallCardType(): bool
    {
        return $this->getCardType() === CardType::CARD_SMALL;
    }
}