<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

class AddressWidget extends BaseGeneralWidget
{
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'address';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Address', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextControls($this->getSelector());

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    private function getSelector(): string
    {
        return '.' . tdf_prefix() . '-address';
    }

}