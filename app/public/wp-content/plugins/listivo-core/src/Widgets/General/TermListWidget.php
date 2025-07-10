<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TermListWithImagesControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class TermListWidget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use TermListWithImagesControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'term_list';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Term list', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addTermsControl();

        $this->endControlsSection();
    }

}