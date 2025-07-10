<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TermListWithImagesControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControl;

class TermListV2Widget extends BaseGeneralWidget
{
    use TextControl;
    use TermListWithImagesControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'term_list_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Term list V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTextControl();

        $this->addTermsControl();

        $this->endControlsSection();
    }

}