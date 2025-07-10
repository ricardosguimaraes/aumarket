<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextAlignControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextColorControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TypographyControl;

class EmailWidget extends BaseGeneralWidget
{
    use TextColorControl;
    use TextAlignControl;
    use TypographyControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'email';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('E-mail', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTypographyControl($this->getSelector());

        $this->addTextAlignControl('.' . tdf_prefix() . '-email-wrapper');

        $this->addTextColorControl($this->getSelector());

        $this->addTextColorControl(
            $this->getSelector() . ':hover',
            'color_hover',
            tdf_admin_string('color_hover')
        );

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    private function getSelector(): string
    {
        return '.' . tdf_prefix() . '-email';
    }

}