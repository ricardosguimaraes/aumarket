<?php

namespace Tangibledesign\Framework\Models;

use Elementor\Core\Base\Document;
use Elementor\Plugin;
use Tangibledesign\Framework\Models\Post\Post;
use Tangibledesign\Framework\Models\Template\Helpers\HasLayout;
use Tangibledesign\Framework\Models\Template\Helpers\HasTransparentMenu;

class Page extends Post
{
    use HasLayout;
    use HasTransparentMenu;

    /**
     * @return Document|false
     */
    public function getDocument()
    {
        return Plugin::instance()->documents->get($this->getId());
    }
}