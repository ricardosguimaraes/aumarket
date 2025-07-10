<?php

namespace Tangibledesign\Framework\Widgets\BlogArchive;

use Tangibledesign\Framework\Widgets\Helpers\BasePostArchiveWidget;

class BlogArchiveTitleWidget extends BasePostArchiveWidget
{
    public function getKey(): string
    {
        return 'blog_archive_title';
    }

    public function getName(): string
    {
        return tdf_admin_string('blog_title');
    }
}