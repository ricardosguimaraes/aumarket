<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\TestimonialsV3Control;

class TestimonialListWidget extends BaseGeneralWidget
{
    use TestimonialsV3Control;

    public function getKey(): string
    {
        return 'testimonial_list';
    }

    public function getName(): string
    {
        return esc_html__('Testimonial list', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTestimonialsControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addTestimonialStyleControls();

        $this->endControlsSection();
    }
}