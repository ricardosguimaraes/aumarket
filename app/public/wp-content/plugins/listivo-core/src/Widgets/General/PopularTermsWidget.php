<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Tangibledesign\Framework\Widgets\Helpers\Controls\JustifyContentControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;

/**
 * Class PopularTermsWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class PopularTermsWidget extends \Tangibledesign\Framework\Widgets\General\PopularTermsWidget
{
    use SimpleLabelControl;
    use JustifyContentControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'popular_terms';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Popular Terms', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl(esc_html__("Check Popular:", 'listivo-core'));

        $this->addTaxonomyControl();

        $this->addLimitControl('', 4);

        $this->addRandomizeControls();

        $this->addJustifyContentControl('.listivo-popular');

        $this->endControlsSection();
    }

}