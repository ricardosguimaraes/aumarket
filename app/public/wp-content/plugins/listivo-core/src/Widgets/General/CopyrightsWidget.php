<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

/**
 * Class CopyrightsWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class CopyrightsWidget extends BaseGeneralWidget
{
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'copyrights';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Copyrights', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextControls('.listivo-copyrights__container');

        $this->endControlsSection();
    }

}