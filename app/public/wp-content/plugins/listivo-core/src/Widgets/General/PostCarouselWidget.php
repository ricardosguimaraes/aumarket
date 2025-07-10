<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\QueryPostsControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BoxArrowStyleControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonTypeControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class PostCarouselWidget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use QueryPostsControl;
    use ButtonTypeControl;
    use BoxArrowStyleControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'post_carousel';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Post carousel', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addButtonTypeControl();

        $this->addQueryPostsControls();

        $this->endControlsSection();

        $this->addBoxArrowStyleSection();
    }

}