<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Repeater;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TermsWithImagesControl;

/**
 * Class TermsWithImagesWidget
 * @package Tangibledesign\Listivo\Widgets
 */
class TermsWithImagesWidget extends BaseGeneralWidget
{
    use TermsWithImagesControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'terms_with_images';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Terms With Images', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTermsWithImagesControls();

        $this->endControlsSection();
    }

}