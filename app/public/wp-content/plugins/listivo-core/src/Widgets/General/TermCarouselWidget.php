<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TermListWithImagesControl;

class TermCarouselWidget extends BaseGeneralWidget
{
    use TermListWithImagesControl;

    public function getKey(): string
    {
        return 'term_carousel';
    }

    public function getName(): string
    {
        return esc_html__('Term Carousel', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTermsControl();

        $this->endControlsSection();
    }
}