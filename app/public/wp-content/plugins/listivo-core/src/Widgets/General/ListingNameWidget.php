<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

class ListingNameWidget extends BaseModelSingleWidget
{
    use TextControls;

    public function getKey(): string
    {
        return 'listing_name';
    }

    public function getName(): string
    {
        return esc_html__('Listing Name', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addHtmlTagControl();

        $this->addTextControls('.listivo-listing-name');

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addHtmlTagControl(): void
    {
        $this->add_control(
            'html_tag',
            [
                'label' => esc_html__('HTML Tag', 'listivo-core'),
                'type' => 'select',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'DIV',
                    'span' => 'SPAN',
                ],
                'default' => 'h1',
            ]
        );
    }

    public function getTag(): string
    {
        $tag = $this->get_settings_for_display('html_tag');
        if (!in_array($tag, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span'], true)) {
            return 'h2';
        }

        return $tag;
    }

}