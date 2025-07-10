<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonTypeControl;

class BlogKeywordSearchWidget extends BaseGeneralWidget
{
    use ButtonTypeControl;

    public function getKey(): string
    {
        return 'blog_keyword_search';
    }

    public function getName(): string
    {
        return tdf_admin_string('blog_keyword_search');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addButtonTypeControl();

        $this->endControlsSection();
    }
}