<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Tangibledesign\Framework\Widgets\Helpers\Controls\MarginControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;

class PrintUserWidget extends BasePrintModelWidget
{
    use SimpleLabelControl;
    use MarginControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'print_user';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('User', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl();

        $this->addMarginControl('.listivo-print-user-wrapper');

        $this->endControlsSection();
    }

}